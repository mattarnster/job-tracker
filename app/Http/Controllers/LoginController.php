<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials))
        {
            $user = User::where('email', $credentials["email"])->first();
            $token = $user->createToken('user-token');
            return response()->json(['token' => $token->plainTextToken]);
        }

        return response()->json(['error' => 'Not authorized.'], 403);
    }
}
