<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware will be handled in routes
    }

    private function isAdmin()
    {
        // Check if user is admin (you can modify this logic based on your requirements)
        return Auth::user()->email === 'admin@nutrinet.com' || 
               (method_exists(Auth::user(), 'hasRole') && Auth::user()->hasRole('admin'));
    }

    public function dashboard()
    {
        try {
            // Calculate total revenue from package prices
            $totalRevenue = Payment::with('package')->get()->sum(function($payment) {
                return $payment->package ? $payment->package->package_price : 0;
            });

            $stats = [
                'total_users' => User::count(),
                'total_packages' => Package::count(),
                'total_orders' => Payment::count(),
                'total_revenue' => $totalRevenue,
                'recent_orders' => Payment::with(['user', 'package'])->latest()->take(5)->get(),
                'recent_users' => User::latest()->take(5)->get()
            ];

            return view('admin.dashboard', compact('stats'));
        } catch (\Exception $e) {
            \Log::error('Admin dashboard error: ' . $e->getMessage());
            return view('admin.dashboard', [
                'stats' => [
                    'total_users' => 0,
                    'total_packages' => 0,
                    'total_orders' => 0,
                    'total_revenue' => 0,
                    'recent_orders' => collect(),
                    'recent_users' => collect()
                ]
            ]);
        }
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function packages()
    {
        $packages = Package::latest()->paginate(15);
        return view('admin.packages', compact('packages'));
    }

    public function createPackage()
    {
        return view('admin.packages.create');
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|max:255',
            'package_price' => 'required|numeric|min:0|max:9999999.99', // Max 10 digits (8 before decimal + 2 after)
            'package_description' => 'nullable|string'
        ], [
            'package_price.max' => 'Package price cannot exceed 9,999,999.99',
            'package_price.numeric' => 'Package price must be a valid number',
            'package_price.min' => 'Package price cannot be negative'
        ]);

        try {
            Package::create([
                'package_name' => $request->package_name,
                'package_price' => $request->package_price,
                'package_description' => $request->package_description
            ]);

            return redirect()->route('admin.packages')->with('success', 'Package created successfully!');
        } catch (\Exception $e) {
            \Log::error('Package creation error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error creating package: ' . $e->getMessage());
        }
    }

    public function editPackage(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function updatePackage(Request $request, Package $package)
    {
        $request->validate([
            'package_name' => 'required|string|max:255',
            'package_price' => 'required|numeric|min:0',
            'package_description' => 'nullable|string'
        ]);

        $package->update([
            'package_name' => $request->package_name,
            'package_price' => $request->package_price,
            'package_description' => $request->package_description
        ]);

        return redirect()->route('admin.packages')->with('success', 'Package updated successfully!');
    }

    public function deletePackage(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages')->with('success', 'Package deleted successfully!');
    }

    public function orders()
    {
        $orders = Payment::with(['user', 'package'])->latest()->paginate(15);
        
        // Calculate total revenue from packages
        $totalRevenue = Payment::with('package')->get()->sum(function($payment) {
            return $payment->package ? $payment->package->package_price : 0;
        });
        
        return view('admin.orders', compact('orders', 'totalRevenue'));
    }

    public function faqs()
    {
        $faqs = Faq::latest()->paginate(15);
        return view('admin.faqs', compact('faqs'));
    }

    public function createFaq()
    {
        return view('admin.faqs.create');
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string'
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        return redirect()->route('admin.faqs')->with('success', 'FAQ created successfully!');
    }

    public function editFaq(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string'
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        return redirect()->route('admin.faqs')->with('success', 'FAQ updated successfully!');
    }

    public function deleteFaq(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs')->with('success', 'FAQ deleted successfully!');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    // Delete User
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting admin users
            $adminEmails = [
                'admin@nutrinet.com',
                'admin@example.com', 
                'admin@test.com',
                'admin@localhost'
            ];
            
            if (in_array(strtolower($user->email), array_map('strtolower', $adminEmails))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete admin users!'
                ], 403);
            }
            
            $userName = $user->name;
            $user->delete();
            
            return response()->json([
                'success' => true,
                'message' => "User '{$userName}' has been deleted successfully!"
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Delete user error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], 500);
        }
    }
}