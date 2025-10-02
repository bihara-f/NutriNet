<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile(): JsonResponse
    {
        return response()->json([
            'user' => Auth::user()->toApiArray()
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update($request->only(['name', 'email']));

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user->toApiArray()
        ]);
    }

    public function deleteAccount(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete(); // Revoke all tokens
        $user->delete();

        return response()->json([
            'message' => 'Account deleted successfully'
        ]);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'error' => 'Current password is incorrect'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Password changed successfully'
        ]);
    }

    // Token management methods
    public function getTokens(): JsonResponse
    {
        return response()->json([
            'tokens' => Auth::user()->tokens->map(function ($token) {
                return [
                    'id' => $token->id,
                    'name' => $token->name,
                    'abilities' => $token->abilities,
                    'created_at' => $token->created_at,
                    'last_used_at' => $token->last_used_at,
                ];
            })
        ]);
    }

    public function createToken(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'array',
        ]);

        $token = Auth::user()->createApiToken(
            $request->name,
            $request->abilities ?? ['*']
        );

        return response()->json([
            'message' => 'Token created successfully',
            'token' => $token
        ]);
    }

    public function revokeToken($tokenId): JsonResponse
    {
        Auth::user()->tokens()->where('id', $tokenId)->delete();

        return response()->json([
            'message' => 'Token revoked successfully'
        ]);
    }

    public function revokeAllTokens(): JsonResponse
    {
        Auth::user()->revokeAllTokens();

        return response()->json([
            'message' => 'All tokens revoked successfully'
        ]);
    }

    // Two-factor authentication methods (placeholder)
    public function enableTwoFactor(): JsonResponse
    {
        return response()->json([
            'message' => 'Two-factor authentication feature not implemented yet'
        ], 501);
    }

    public function disableTwoFactor(): JsonResponse
    {
        return response()->json([
            'message' => 'Two-factor authentication feature not implemented yet'
        ], 501);
    }

    public function getRecoveryCodes(): JsonResponse
    {
        return response()->json([
            'message' => 'Recovery codes feature not implemented yet'
        ], 501);
    }

    public function regenerateRecoveryCodes(): JsonResponse
    {
        return response()->json([
            'message' => 'Recovery codes feature not implemented yet'
        ], 501);
    }

    // Admin methods
    public function getAllUsers(): JsonResponse
    {
        $users = User::latest()->paginate(15);
        
        return response()->json([
            'users' => $users->items(),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ]
        ]);
    }

    public function getStatistics(): JsonResponse
    {
        return response()->json([
            'total_users' => User::count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'recent_users' => User::where('created_at', '>=', now()->subDays(30))->count(),
        ]);
    }

    public function suspendUser(User $user): JsonResponse
    {
        // Implement user suspension logic
        return response()->json([
            'message' => 'User suspension feature not implemented yet'
        ], 501);
    }

    public function unsuspendUser(User $user): JsonResponse
    {
        // Implement user unsuspension logic
        return response()->json([
            'message' => 'User unsuspension feature not implemented yet'
        ], 501);
    }
}