<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class LoginController extends Controller
{
    public function login(Request $request) {
        validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($request->only('email', 'password'))) {
            return response()->json(Auth::user(), 200);
        }

        throw ValidationValidationException::withMessages([
            'email' => ["The email or password is incorrect."]
        ]);
    }

    public function logout() {
        Auth::logout();
        Cookie::forget('laravel_session');
        return redirect('/');
    }
}
