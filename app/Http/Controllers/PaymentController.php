<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('signin');
        }

        $fullname = $request->fullname;
        $email = $request->email;
        $address = $request->address;
        $country = $request->country;
        $zip_code = $request->zip_code;
        $card_number = $request->card_number;
        $expiration_date = $request->expiration_date;
        $cvv = $request->cvv;

        // Get cart items
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('payment_error', true);
        }

        try {
            // Process payment for each cart item (like old semester)
            foreach ($cart as $item) {
                Payment::create([
                    'user_id' => Auth::id(),
                    'full_name' => $fullname,
                    'email' => $email,
                    'address' => $address,
                    'country' => $country,
                    'zip_code' => $zip_code,
                    'card_number' => $card_number,
                    'expiration_date' => $expiration_date,
                    'cvv' => $cvv,
                    'package_id' => $item['id']
                ]);
            }

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