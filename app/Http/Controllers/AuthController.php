<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken(Auth::user()->name);
            if(Auth::user()->status === 'Débloquer'){
                return response()->json(['token' => $token->plainTextToken, "user" => Auth::user()], 200);

            }else{
                return response()->json(['Message' => 'Your account is blocked']);
            }

        }

        return response()->json(["error" => "User not found"], 404);
    }
}
