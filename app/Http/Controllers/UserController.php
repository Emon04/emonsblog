<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('auth.userRegistration');
    }
    public function save(Request $request){

        $this->validate($request,[
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required|confirmed',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = '3';
        $user->username = $request->username;

        $user->save();
        return redirect()->route('login');
    }
}
