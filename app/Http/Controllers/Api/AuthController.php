<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

    public function register(Request $reauset)
    {

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
