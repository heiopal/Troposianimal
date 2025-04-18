<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function halamanlogin(){
        return view('login');
    }

    public function postlogin(Request $request){
        if(Auth::attempt($request->only('username','password'))){
            return redirect('/dashboard');
        }
        return redirect('/');
    }

    public function logout(Request $request){
      Auth::logout();
      return redirect('/');
    }
}
