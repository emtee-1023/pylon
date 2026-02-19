<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Dedoc\Scramble\Attributes\Security;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

class AuthenticationController extends Controller
{
    /**
     * Login
     *
     * @unauthenticated
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    /**
     * Get Profile Details
     * 
     * This endpoint returns the profile details of the current authenticated user
     * 
     */
    public function profile()
    {
        return Auth::user();
    }

    /**
     * Logout
     * 
     * This endpoint logs out the current authenticated user
     */
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
