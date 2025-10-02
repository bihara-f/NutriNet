<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class CartController extends Controller
{
    /**
     * Add item to cart
     */
    public function addToCart(Request $request)
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return response()->json([
                'error' => 'Please sign in to add items to cart',
                'redirect' => route('login')
            ], 401);
        }

        $packageId = $request->package_id;
        $packageName = $request->package_name;
        $packagePrice = $request->package_price;

        // Get current cart from session
        $cart = session()->get('cart', []);

        // If cart is empty, add the first item
        if (empty($cart)) {
            $cart[$packageId] = [
                "id" => $packageId,
                "name" => $packageName,
                "price" => $packagePrice,
                "quantity" => 1
            ];
        } else {
            // If item already exists in cart, increase quantity
            if (isset($cart[$packageId])) {
                $cart[$packageId]['quantity']++;
            } else {
                // Add new item to cart
                $cart[$packageId] = [
                    "id" => $packageId,
                    "name" => $packageName,
                    "price" => $packagePrice,
                    "quantity" => 1
                ];
            }
        }

        session()->put('cart', $cart);
        
        return response()->json([
            'success' => 'Package added to cart successfully!',
            'cart_count' => count($cart)
        ]);
    }

    /**
     * Show cart page
     */
    public function showCart()
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please sign in to view your cart');
        }

        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart', compact('cart', 'total'));
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(Request $request)
    {
        $packageId = $request->package_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$packageId])) {
            unset($cart[$packageId]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => 'Package removed from cart successfully!',
            'cart_count' => count($cart)
        ]);
    }

    /**
     * Update cart quantity
     */
    public function updateCart(Request $request)
    {
        $packageId = $request->package_id;
        $quantity = $request->quantity;
        $cart = session()->get('cart', []);

        if (isset($cart[$packageId])) {
            $cart[$packageId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => 'Cart updated successfully!',
            'cart_count' => count($cart)
        ]);
    }

    /**
     * Clear cart
     */
    public function clearCart()
    {
        session()->forget('cart');
        return response()->json(['success' => 'Cart cleared successfully!']);
    }

    /**
     * Get cart count for header display
     */
    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        return response()->json(['count' => count($cart)]);
    }
}