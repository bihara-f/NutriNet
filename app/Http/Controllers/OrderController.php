<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show user's orders
     */
    public function index()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please sign in to view your orders');
        }

        // Get all orders for the current user
        $orders = Payment::where('user_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('my-orders', compact('orders'));
    }

    /**
     * Show single order details
     */
    public function show($id)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please sign in to view your orders');
        }

        // Get specific order for the current user
        $order = Payment::where('user_id', Auth::id())
                       ->where('id', $id)
                       ->firstOrFail();

        return view('order-details', compact('order'));
    }
}