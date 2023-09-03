<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UserController extends Controller
{
    public function index()
    {
        $users=User::paginate(20);
        $roles=Role::all();
        return Inertia::render('User/UserIndex',[
            'users'=>$users,'roles'=> $roles]);  
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'required|min:8',
            'role'=>'required',
        ]);

        $User = new User();
        $User->name = $request->name;
        $User->email = $request->email;
        $User->password=Hash::make($request->name);
        $User->save();
        $User->assignRole($request->input('role'));

        return back()->with('success','Added new user successfully');

    }
}
