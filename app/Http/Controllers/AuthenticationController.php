<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    /**
     * Login
     *
     * @unauthenticated
     */
    public function login(LoginRequest $request)
    {
        try {
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
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during login.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get Profile Details
     *
     * This endpoint returns the profile details of the current authenticated user
     */
    public function profile()
    {
        try {
            return Auth::user();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching profile.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Logout
     *
     * This endpoint logs out the current authenticated user
     */
    public function logout()
    {
        try {
            Auth::user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during logout.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
