<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        Log::info('=== DashboardController@index called ===');
        
        if (!Auth::check()) {
            Log::info('User not authenticated, redirecting to login');
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        Log::info('User authenticated: ' . $user->email . ' (ID: ' . $user->id . ')');
        
        // Check if user is admin
        if ($this->isAdmin($user)) {
            Log::info('🔑 ADMIN USER DETECTED! Redirecting to admin panel', [
                'user' => $user->email
            ]);
            
            // Use direct route instead of named route in case it doesn't exist
            return redirect('/admin')->with('success', 'Welcome to Admin Panel');
        }
        
        Log::info('👤 Regular user detected, showing home page as dashboard', ['user' => $user->email]);
        // Show the same beautiful home page content for logged-in users
        return view('home');
    }
    
    private function isAdmin($user)
    {
        $adminEmails = [
            'admin@nutrinet.com',
            'admin@example.com', 
            'admin@test.com',
            'admin@localhost'
        ];
        
        $isAdmin = in_array(strtolower($user->email), array_map('strtolower', $adminEmails));
        
        Log::info('Admin check for: ' . $user->email . ' - ' . ($isAdmin ? 'IS ADMIN' : 'Regular User'));
        
        return $isAdmin;
    }
}