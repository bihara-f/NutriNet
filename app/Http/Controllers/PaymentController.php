<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    public function index()
    {
        // Check if user is logged in (session-based like old semester)
        if (!Auth::check()) {
            return redirect()->route('signin')->with('error', 'Please sign in to access payment.');
        }

        // Get cart from session
        $cart = session()->get('cart', []);
        
        // If cart is empty, redirect to packages
        if (empty($cart)) {
            return redirect()->route('packages')->with('error', 'Please add some packages to your cart first.');
        }

        return view('payment-old');
    }

    public function store(PaymentRequest $request)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('signin');
        }

        // Get validated data
        $validated = $request->validated();
        
        $fullname = $validated['full_name'];
        $email = $validated['email'];
        $card_number = $validated['card_number'];
        $expiration_date = $validated['expiry_date'];
        $cvv = $validated['cvv'];
        $package = $validated['package'];
        $amount = $validated['amount'];

        // Get cart items
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('payment_error', true);
        }

        try {
            // Create payment record with validated data
            Payment::create([
                'user_id' => Auth::id(),
                'full_name' => $fullname,
                'email' => $email,
                'card_number' => substr($card_number, -4), // Store only last 4 digits for security
                'expiration_date' => $expiration_date,
                'package' => $package,
                'amount' => $amount,
                'order_id' => 'ORD-' . time() . '-' . Auth::id(),
                'status' => 'completed'
            ]);

            // Clear cart after successful payment
            session()->forget('cart');

            // Show success alert like old semester with JavaScript popup
            return redirect()->route('my.orders')->with('payment_success', true);
            
        } catch (\Exception $e) {
            // Show error alert like old semester
            return redirect()->back()->with('payment_error', true);
        }
    }
}