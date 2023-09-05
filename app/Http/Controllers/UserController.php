<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Exports\ExportUser;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request as searchRequest;

class UserController extends Controller
{
    public function index()
    {
        $users= User::query()
                ->with(['roles'])
                ->when(searchRequest::input('search'), function ($query, $search) 
                {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->when(searchRequest::input('emailsearch'), function ($query, $emailsearch) 
                {
                    $query->where('email',$emailsearch);
                })
                ->when(searchRequest::input('rolesearch'), function ($query, $rolesearch) 
                {
                    $query->whereHas(
                        'roles', function($q) use ($rolesearch){
                            $q->where('id', $rolesearch);
                        }
                    );
                })
              
                    ->select('id','name','email','password','plain_password')
                    ->orderBy('name','ASC')
                    ->paginate(5);
       
        $roles=Role::all();
        return Inertia::render('User/UserIndex',[
            'roles'=> $roles,
            'users'=>$users,
            'emails'=>User::get('email'),
            'filters' => searchRequest::only(['search']),
            'emailfilters' => searchRequest::only(['emailsearch']),
            'rolesearch' => searchRequest::only(['rolesearch']),
        ]);  
    }

    public function register(Request $request)
    {
       
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role'=>'required',
        ]);

        $password = random_int(100000, 999999);
       
        $User = new User();
        $User->name = $request->name;
        $User->email = $request->email;
        $User->password=Hash::make($password);
        $User->plain_password=$password;
        $User->save();
        $User->assignRole($request->input('role'));

        return back()->with('success','Added new user successfully');

    }

    public function resetPassword(Request $request)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'required','min:8',
        ]);
        $User =  User::find($request->id);
        $User->password=Hash::make($request->password);
        $User->plain_password=null;
        $User->save();
        return back()->with('success','Success');
    }

    public function edit($id)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }
        $user=User::where('id', $id)->first();
            if($user){
                return Inertia::render('User/UserEdit',[
                    'user' => $user
                ]);

            }else{
                abort(404);
            }
    }

    public function update(Request $request, $id)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

     
        $user= User::where('id', $id)->first();
       
        if($user){

            $user->name=$request->name;
            $user->email=$request->email;
            $user->plain_password=null;
            $user->update();
            
            return to_route('user')->with('success','Updated successfully');
           
        }

    }

    public function exportUsers()
    {
       
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }

        return Excel::download(new ExportUser,'accounts.csv');
        
        // if($search!=null){
          
        //     $users=User::query()->with(['roles'])
        //                 ->select('id','name','email','created_at')
        //                 ->where(function ($query) use($search) 
        //                 {
        //                     $query->where('name', 'like', '%' . $search . '%');
        //                 })
        //                 ->orWhere(function ($query) use($search) 
        //                 {
        //                     $query->where('email', 'like', '%' . $search . '%');
        //                 })->get();
        // }
      
        
       
    }
    
    public function filter()
{
    $users = app(User::class)->newQuery();

    if ( request()->has('search') && !empty(request()->get('search')) ) {
        $search = request()->query('search');
        $users->where(function ($query) use($search) {
            $query->where('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('mobile', 'LIKE', "%{$search}%");
        });
    }

    return Excel::download(new FilterUserExport($users), 'filter.xlsx');
}

    public function destroy($id)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }

        $user= User::where('id', $id)->delete();
        if($user){
            return back()->with('success','Account was deleted successfully');
        }else{
            abort(404);
        }
  
}
    
}
