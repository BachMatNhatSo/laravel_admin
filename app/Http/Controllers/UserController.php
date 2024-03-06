<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;

class UserController extends Controller
{
    public function index(){
        return view("login");
    }
    public function login(Request $request){
      
        $validationData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
       
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            return response()->json(['message' => 'Login successful'], 200);
           
        }
        return response()->json(['message' => 'Invalid credentials'], 401);

    }

    
}