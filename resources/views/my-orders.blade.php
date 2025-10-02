@extends('layouts.app-old')

@section('title', 'My Orders - Nutrinet Health Checkup Center')

@section('content')
<div class="max-w-6xl mx-auto px-8 py-20 min-h-screen">
    <h1 class="text-5xl font-bold text-center mb-16 text-gray-800">My Orders</h1>
    
    @if(session('payment_success'))
        <script>
            alert('Your payment was successful!');
        </script>
    @endif
    
    @if($orders->isEmpty())
        <div class="text-center py-16">
            <h2 class="text-3xl font-semibold text-gray-600 mb-6">No orders found</h2>
            <p class="text-gray-500 text-lg mb-8">You haven't placed any orders yet.</p>
            <a href="{{ route('packages') }}" 
               class="bg-green-500 text-white px-8 py-3 rounded-full text-lg font-semibold inline-block hover:bg-green-600 hover:transform hover:-translate-y-1 transition-all duration-300">
                Start Shopping
            </a>
        </div>
    @else
        <div class="space-y-8">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 hover:transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                    <!-- Order Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-6 border-b border-gray-200">
                        <div>
                            <div class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</div>
                            <div class="text-gray-600 text-sm mt-1">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</div>
                        </div>
                        <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold mt-2 md:mt-0">
                            Completed
                        </span>
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-500 mb-2">Customer Name</div>
                            <div class="text-gray-800 font-medium">{{ $order->full_name }}</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-500 mb-2">Email</div>
                            <div class="text-gray-800 font-medium">{{ $order->email }}</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-500 mb-2">Package ID</div>
                            <div class="text-gray-800 font-medium">#{{ $order->package_id }}</div>
                        </div>
                    </div>
                    
                    <!-- Billing Information -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-500 mb-2">Billing Address</div>
                            <div class="text-gray-800 font-medium">{{ $order->address }}</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-500 mb-2">Country</div>
                            <div class="text-gray-800 font-medium">{{ $order->country }}</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-500 mb-2">Zip Code</div>
                            <div class="text-gray-800 font-medium">{{ $order->zip_code }}</div>
                        </div>
                    </div>
                    
                    <!-- Payment Information -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-500 mb-2">Card Number</div>
                            <div class="text-gray-800 font-medium">**** **** **** {{ substr($order->card_number, -4) }}</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-500 mb-2">Payment Method</div>
                            <div class="text-gray-800 font-medium">Credit Card</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-500 mb-2">Order Status</div>
                            <div class="text-green-600 font-semibold">Completed</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
