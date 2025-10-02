<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Check if user is admin
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->email === 'admin@nutrinet.com' || in_array($user->email, ['admin@example.com', 'admin@test.com'])) {
                return redirect('/admin');
            }
        }

        // Regular user redirect
        return redirect('/dashboard');
    }
}