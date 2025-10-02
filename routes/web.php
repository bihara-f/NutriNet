<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\OldAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DashboardController;

// Home route - Handle admin redirect after login  
Route::get('/', function () {
    // Check if user is authenticated and admin
    if (Auth::check()) {
        $user = Auth::user();
        Log::info('🏠 Home route accessed by authenticated user: ' . $user->email);
        
        // Check if user is admin
        $adminEmails = [
            'admin@nutrinet.com',
            'admin@example.com', 
            'admin@test.com',
            'admin@localhost'
        ];
        
        $isAdmin = in_array(strtolower($user->email), array_map('strtolower', $adminEmails));
        
        if ($isAdmin) {
            Log::info('🚀 ADMIN detected on home page, redirecting to admin panel: ' . $user->email);
            return redirect('/admin')->with('success', 'Welcome to Admin Panel!');
        }
        
        Log::info('👤 Regular user on home page: ' . $user->email);
    }
    
    return view('home');
})->name('home');

// Dashboard route - Using controller for better reliability
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Public routes - Accessible to all users
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/packages', [PackageController::class, 'index'])->name('packages');
Route::get('/services', [ServicesController::class, 'index'])->name('services');

// About route (static page)
Route::get('/about', function () {
    return view('about');
})->name('about');

// Custom auth routes for old semester design
Route::get('/signin', [OldAuthController::class, 'showLoginForm'])->name('signin');
Route::post('/signin', [OldAuthController::class, 'login'])->name('signin.post');
Route::get('/login', [OldAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [OldAuthController::class, 'login'])->name('login.post');
Route::get('/registration', [OldAuthController::class, 'showRegistrationForm'])->name('registration');
Route::post('/registration', [OldAuthController::class, 'register'])->name('registration.post');
Route::get('/register', [OldAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [OldAuthController::class, 'register'])->name('register.post');
Route::post('/logout-old', [OldAuthController::class, 'logout'])->name('logout.old');

// Cart routes
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

// Payment routes - handle authentication internally like old semester
Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');

// Order routes
Route::get('/my-orders', [OrderController::class, 'index'])->name('my.orders');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.details');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/diet-plans', function () {
        return view('diet-plans');
    })->name('diet-plans');

    // Protected routes
    Route::get('/user-profile', [ProfileController::class, 'show'])->name('user.profile');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/reports/details', [ReportsController::class, 'getPlanDetails'])->name('reports.details');
});

// Simple admin test without middleware
Route::get('/admin-test', function() {
    if (!Auth::check()) {
        return response()->json([
            'logged_in' => false,
            'message' => 'Not logged in',
            'login_url' => route('login')
        ]);
    }
    
    $user = Auth::user();
    $isAdmin = $user->email === 'admin@nutrinet.com' || in_array($user->email, ['admin@example.com', 'admin@test.com']);
    
    return response()->json([
        'logged_in' => true,
        'user_email' => $user->email,
        'user_id' => $user->id,
        'is_admin' => $isAdmin,
        'should_redirect' => $isAdmin ? 'Yes, to admin panel' : 'No, regular user',
        'admin_url' => $isAdmin ? route('admin.dashboard') : null,
        'current_url' => request()->url()
    ]);
});

// Force admin login for testing
Route::get('/force-admin', function() {
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $user = Auth::user();
    if ($user->email === 'admin@nutrinet.com') {
        return redirect()->route('admin.dashboard');
    }
    
    return 'User ' . $user->email . ' is not admin. Only admin@nutrinet.com can access admin panel.';
});

// Admin Routes - Only accessible by admin users
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Test route to check admin access
    Route::get('/test', function() {
        return 'Admin access working! User: ' . Auth::user()->email;
    })->name('test');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Package Management
    Route::get('/packages', [AdminController::class, 'packages'])->name('packages');
    Route::get('/packages/create', [AdminController::class, 'createPackage'])->name('packages.create');
    Route::post('/packages', [AdminController::class, 'storePackage'])->name('packages.store');
    Route::get('/packages/{package}/edit', [AdminController::class, 'editPackage'])->name('packages.edit');
    Route::put('/packages/{package}', [AdminController::class, 'updatePackage'])->name('packages.update');
    Route::delete('/packages/{package}', [AdminController::class, 'deletePackage'])->name('packages.delete');
    
    // Order Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    
    // FAQ Management
    Route::get('/faqs', [AdminController::class, 'faqs'])->name('faqs');
    Route::get('/faqs/create', [AdminController::class, 'createFaq'])->name('faqs.create');
    Route::post('/faqs', [AdminController::class, 'storeFaq'])->name('faqs.store');
    Route::get('/faqs/{faq}/edit', [AdminController::class, 'editFaq'])->name('faqs.edit');
    Route::put('/faqs/{faq}', [AdminController::class, 'updateFaq'])->name('faqs.update');
    Route::delete('/faqs/{faq}', [AdminController::class, 'deleteFaq'])->name('faqs.delete');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});
