<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    // Register a new user
    public function register(RegisterRequest $request): JsonResponse
    {
        // Rate limiting
        $key = 'register:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return response()->json(['error' => 'Too many registration attempts'], 429);
        }
        RateLimiter::hit($key, 3600);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'contact_number' => $request->contact_number,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
                'terms_accepted_at' => now(),
            ]);

            $token = $user->createApiToken('registration-token', ['*'], now()->addYear());

            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'user' => $user->toApiArray(),
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => now()->addYear()->toISOString()
            ], 201);

        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'ip_address' => $request->ip()
            ]);

            return response()->json(['error' => 'Registration failed'], 500);
        }
    }

    // Login user
    public function login(Request $request): JsonResponse
    {
        // Rate limiting
        $key = 'login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json(['error' => 'Too many login attempts'], 429);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'device_name' => 'nullable|string|max:255',
            'remember' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::hit($key, 900); // 15 minutes penalty
            
            Log::warning('Failed login attempt', [
                'email' => $request->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        try {
            $deviceName = $request->device_name ?? $request->userAgent();
            $expiresAt = $request->remember ? now()->addYear() : now()->addDays(30);
            
            $token = $user->createApiToken($deviceName, ['*'], $expiresAt);
            $user->updateLastLogin();

            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'device_name' => $deviceName
            ]);

            return response()->json([
                'user' => $user->toApiArray(),
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $expiresAt->toISOString()
            ]);

        } catch (\Exception $e) {
            Log::error('Login processing failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'ip_address' => $request->ip()
            ]);

            return response()->json(['error' => 'Login failed'], 500);
        }
    }

    // Logout user
    public function logout(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $user->currentAccessToken()->delete();

            Log::info('User logged out', [
                'user_id' => $user->id,
                'ip_address' => $request->ip()
            ]);

            return response()->json(['message' => 'Logged out successfully']);

        } catch (\Exception $e) {
            Log::error('Logout failed', [
                'error' => $e->getMessage(),
                'ip_address' => $request->ip()
            ]);

            return response()->json(['error' => 'Logout failed'], 500);
        }
    }

    // Logout from all devices
    public function logoutAll(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $user->revokeAllTokens();

            Log::info('User logged out from all devices', [
                'user_id' => $user->id,
                'ip_address' => $request->ip()
            ]);

            return response()->json(['message' => 'Logged out from all devices successfully']);

        } catch (\Exception $e) {
            Log::error('Logout all failed', [
                'error' => $e->getMessage(),
                'ip_address' => $request->ip()
            ]);

            return response()->json(['error' => 'Logout failed'], 500);
        }
    }

    // Get authenticated user
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()->toApiArray()
        ]);
    }

    /**
     * Refresh token (placeholder for future implementation)
     */
    public function refresh(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $currentToken = $user->currentAccessToken();
            
            // Create new token with same abilities and expiration
            $newToken = $user->createApiToken(
                $currentToken->name,
                $currentToken->abilities,
                $currentToken->expires_at
            );
            
            // Revoke current token
            $currentToken->delete();

            Log::info('Token refreshed', [
                'user_id' => $user->id,
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'token' => $newToken,
                'token_type' => 'Bearer',
                'expires_at' => $currentToken->expires_at?->toISOString()
            ]);

        } catch (\Exception $e) {
            Log::error('Token refresh failed', [
                'error' => $e->getMessage(),
                'ip_address' => $request->ip()
            ]);

            return response()->json(['error' => 'Token refresh failed'], 500);
        }
    }

    /**
     * Forgot password (placeholder)
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Implementation would involve sending password reset email
        Log::info('Password reset requested', [
            'email' => $request->email,
            'ip_address' => $request->ip()
        ]);

        return response()->json(['message' => 'Password reset email sent']);
    }

    /**
     * Reset password (placeholder)
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Implementation would involve verifying token and updating password
        Log::info('Password reset completed', [
            'email' => $request->email,
            'ip_address' => $request->ip()
        ]);

        return response()->json(['message' => 'Password reset successfully']);
    }
}