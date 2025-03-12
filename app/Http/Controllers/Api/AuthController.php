<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            $user->tokens()->delete();

            $token = $user->createToken($user->email)->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        $credentials['password'] = Hash::make($credentials['password']);

        // dd($credentials);

        $user = \App\Models\User::create($credentials);
        $user->email_verified_at = now();
        $user->save();

        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function logout(Request $request)
    {
        // log request header and content
        Log::info("Request header: " . json_encode($request->header()));
        Log::info("Request content: " . json_encode($request->all()));

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Token deleted',
        ], 200);
    }
}
