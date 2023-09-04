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
                ->when(searchRequest::input('search'), function ($query, $search) 
                {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                    ->select('id','name','email','plain_password')
                    ->orderBy('name','ASC')
                    ->with(['roles'])
                    ->paginate(5);
         
        $roles=Role::all();
        return Inertia::render('User/UserIndex',[
            'roles'=> $roles,
            'users'=>$users,
            'filters' => searchRequest::only(['search']),
        ]);  
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role'=>'required',
        ]);

        $password = random_int(100000, 999999);
       
        $User = new User();
        $User->name = $request->name;
        $User->email = $request->email;
        $User->plain_password=$password;
        $User->save();
        $User->assignRole($request->input('role'));

        return back()->with('success','Added new user successfully');

    }

    public function resetPassword(Request $request)
    {
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
        $user=User::where('id', $id)->first();
            if($user){
                return Inertia::render('User/UserEdit',[
                    'user' => $user
                ]);

            }else{
                abort(404);
            }
    }

    public function update(Request $request, $id){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

     
        $user= User::where('id', $id)->first();
       
        if($user){

            $user->name=$request->name;
            $user->email=$request->email;
            $user->update();
            
            return to_route('user')->with('success','Updated successfully');
           
        }

    }

    public function exportUsers(Request $request){
        return Excel::download(new ExportUser, 'accounts.csv');
    }

    public function destroy($id){
        $user= User::where('id', $id)->delete();
        if($user){
            return back()->with('success','Account was deleted successfully');
        }else{
            abort(404);
        }
  
}
    
}
