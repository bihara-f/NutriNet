<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            \Log::info('Admin middleware: User not authenticated');
            return redirect()->route('login')->with('error', 'Please login to access admin panel.');
        }

        // Check if user is admin
        $user = Auth::user();
        \Log::info('Admin middleware: Checking user', ['email' => $user->email]);
        
        if ($user->email !== 'admin@nutrinet.com' && !$this->hasAdminRole($user)) {
            \Log::info('Admin middleware: Access denied for user', ['email' => $user->email]);
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        \Log::info('Admin middleware: Access granted', ['email' => $user->email]);
        return $next($request);
    }

    /**
     * Check if user has admin role
     */
    private function hasAdminRole($user): bool
    {
        // You can implement role-based checking here if you have a roles system
        // For now, we'll just check specific email addresses
        $adminEmails = [
            'admin@nutrinet.com',
            'admin@example.com',
            'admin@test.com'
        ];

        return in_array($user->email, $adminEmails);
    }
}