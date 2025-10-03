<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class OldAuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login-old');
    }

    // Handle user login
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        // Check for empty credentials
        if (empty($username) || empty($password)) {
            return redirect()->back()->withErrors(['error' => 'emptycredentials'])->withInput();
        }

        // Find user by email or username
        $user = User::where('email', $username)->orWhere('name', $username)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'invalidusername'])->withInput();
        }

        if (!Hash::check($password, $user->password)) {
            return redirect()->back()->withErrors(['error' => 'invalidpassword'])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();
        
        return redirect()->intended('/');
    }

    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register-old');
    }

    // Handle user registration
    public function register(Request $request)
    {
        // Get form data - handle both old form and Jetstream form
        $name = $request->name ?? ($request->firstname . ' ' . $request->lastname);
        $email = $request->email;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation ?? $request->confirmPassword;
        
        // Generate username if not provided
        $username = $request->username ?? strtolower(str_replace(' ', '', $name)) . rand(100, 999);
        $contact_number = $request->contact ?? $request->contact_number ?? '0000000000';
        
        // Convert gender to lowercase for database consistency
        $gender = strtolower($request->gender ?? 'other');

        // Basic validation
        if (empty($name) || empty($email) || empty($password)) {
            return redirect()->back()->withErrors(['error' => 'Name, email, and password are required'])->withInput();
        }

        if (empty($request->firstname) || empty($request->lastname)) {
            return redirect()->back()->withErrors(['error' => 'First name and last name are required'])->withInput();
        }

        if ($password !== $password_confirmation) {
            return redirect()->back()->withErrors(['error' => 'Passwords do not match'])->withInput();
        }

        if (strlen($password) < 8) {
            return redirect()->back()->withErrors(['error' => 'Password must be at least 8 characters long'])->withInput();
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withErrors(['error' => 'Please enter a valid email address'])->withInput();
        }

        // Check if email already exists
        if (User::where('email', $email)->exists()) {
            return redirect()->back()->withErrors(['error' => 'Email already exists'])->withInput();
        }

        // Make sure username is unique
        $originalUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        try {
            // Create user with all required fields
            $user = User::create([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'contact_number' => $contact_number,
                'gender' => $gender,
                'password' => Hash::make($password),
                'email_verified_at' => now(), // Auto-verify for simplicity
            ]);

            // Log successful registration
            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name
            ]);

            // Show success message and redirect to sign in
            return redirect()->route('signin')->with('success', 'Registration successful! Please sign in.');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'email' => $email,
                'name' => $name,
                'username' => $username
            ]);
            
            return redirect()->back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
        }
    }

    // Handle user logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}