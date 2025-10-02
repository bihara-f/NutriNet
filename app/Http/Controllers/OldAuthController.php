<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class OldAuthController extends Controller
{
    /**
     * Show the old semester login form
     */
    public function showLoginForm()
    {
        return view('auth.login-old');
    }

    /**
     * Handle old semester login
     */
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

    /**
     * Show the old semester registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register-old');
    }

    /**
     * Handle old semester registration
     */
    public function register(Request $request)
    {
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $email = $request->email;
        $contact = $request->contact;
        $username = $request->username;
        $password = $request->password;
        $confirmPassword = $request->confirmPassword;
        $gender = $request->gender;

        // Basic validation
        if (empty($firstname) || empty($lastname) || empty($email) || empty($contact) || 
            empty($username) || empty($password) || empty($confirmPassword) || empty($gender)) {
            return redirect()->back()->withErrors(['error' => 'All fields are required'])->withInput();
        }

        if ($password !== $confirmPassword) {
            return redirect()->back()->withErrors(['error' => 'Passwords do not match'])->withInput();
        }

        // Check if email already exists
        if (User::where('email', $email)->exists()) {
            return redirect()->back()->withErrors(['error' => 'Email already exists'])->withInput();
        }

        // Check if username already exists
        if (User::where('name', $username)->exists()) {
            return redirect()->back()->withErrors(['error' => 'Username already exists'])->withInput();
        }

        try {
            // Create user
            $user = User::create([
                'name' => $username,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            // Show success message and redirect to sign in
            return redirect()->route('signin')->with('success', 'Registration successful! Please sign in.');
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}