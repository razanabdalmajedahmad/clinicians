<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return redirect()->route('get_login');
    }
    public function login(){
        return view('login');
    }
    public function login_post(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user=$request->only('email','password');
        $token=Auth::attempt($user,$request->remember_me);
        if($token){
            return redirect()->route('home')->with('success','Logged in successfully');
        }else{
            return back()->with('error','user not found');
        }
    }
}
