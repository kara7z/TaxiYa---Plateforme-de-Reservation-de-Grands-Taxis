<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    function create(){
        return view('auth.register');
    }
    function store( Request $request){
        $validated = request()->validate([
            'name'=>['required','max:255','string'],
            'email'=>['string','email','required','max:255','unique:users'],
            'password'=>['string','required','max:255','min:8',Password::default()],
        ]);
        $user = User::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'password'=>$request->password,
            'role'=>'passenger'
        ]);
        Auth::login($user);

        return redirect('/');

    }
    
}