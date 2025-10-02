@extends('layouts.app-old')

@section('title', 'Shopping Cart - Nutrinet Health Checkup Center')

@section('content')
<div class="max-w-4xl mx-auto px-8 py-20 min-h-screen">
    <h1 class="text-5xl font-bold text-center mb-16 text-gray-800">Shopping Cart</h1>
    
    @if(empty($cart))
        <div class="text-center py-16">
            <h2 class="text-3xl font-semibold text-gray-600 mb-6">Your cart is empty</h2>
            <p class="text-gray-500 text-lg mb-8">Add some packages to get started!</p>
            <a href="{{ route('packages') }}" 
               class="bg-green-500 text-white px-8 py-2 rounded-full text-base font-medium hover:bg-green-600 hover:transform hover:-translate-y-1 transition-all duration-300">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($cart as $id => $item)
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6" data-id="{{ $id }}">
                    <div class="flex-1">
                        <div class="text-2xl font-bold text-gray-800 mb-2">{{ $item['name'] }}</div>
                        <div class="text-xl font-semibold text-green-600">${{ number_format($item['price'], 2) }}</div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-4">
                            <button onclick="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})" 
                                    class="bg-green-500 text-white w-8 h-8 rounded-full hover:bg-green-600 transition-colors duration-300 flex items-center justify-center font-bold">
                                -
                            </button>
                            <span class="text-xl font-semibold min-w-8 text-center">{{ $item['quantity'] }}</span>
                            <button onclick="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})" 
                                    class="bg-green-500 text-white w-8 h-8 rounded-full hover:bg-green-600 transition-colors duration-300 flex items-center justify-center font-bold">
                                +
                            </button>
                        </div>
                        <button onclick="removeFromCart({{ $id }})" 
                                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-300 font-semibold">
                            Remove
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-12 bg-gray-50 rounded-2xl p-8 flex justify-end items-center gap-6">
            <div class="text-3xl font-bold text-gray-800">Total: ${{ number_format($total, 2) }}</div>
            <a href="{{ route('payment') }}" 
               class="bg-green-500 text-white px-6 py-2 rounded-full text-base font-medium hover:bg-green-600 hover:transform hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                Proceed to Payment
            </a>
        </div>
    @endif
</div>

<script>
function updateQuantity(packageId, quantity) {
    if (quantity < 1) {
        removeFromCart(packageId);
        return;
    }
    
    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            package_id: packageId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function removeFromCart(packageId) {
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                package_id: packageId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endsection
