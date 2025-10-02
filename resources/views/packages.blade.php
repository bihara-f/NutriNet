@extends('layouts.app-old')

@section('title', 'Packages - Nutrinet Health Checkup Center')

@section('content')
    <!-- Cart Icon - Tailwind CSS -->
    <a href="{{ route('cart') }}" class="fixed top-24 right-5 bg-green-500 text-white p-4 rounded-full shadow-xl z-50 hover:bg-green-600 transition-colors duration-300 text-xl">
        <i class="fa fa-shopping-cart"></i>
        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">0</span>
    </a>

    <div class="max-w-7xl mx-auto px-8 py-20">
        <h3 class="text-5xl font-bold text-center text-gray-800 mb-16">Our Packages</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Diet Plan Package -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="{{ asset('images/diet-plans-1.jpeg') }}" alt="Diet Plan" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Diet Plan</h3>
                    <div class="text-3xl font-bold text-green-600 mb-6">$700</div>
                    <button onclick="addToCart(1, 'Diet Plan', 700)" 
                            class="w-full bg-green-500 text-white py-3 px-6 rounded-full font-semibold text-lg hover:bg-green-600 hover:transform hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                        Add to Cart
                    </button>
                </div>
            </div>
            
            <!-- Fitness Training Package -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="{{ asset('images/fittrain.jpeg') }}" alt="Fitness Training" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Fitness Training</h3>
                    <div class="text-3xl font-bold text-green-600 mb-6">$700</div>
                    <button onclick="addToCart(2, 'Fitness Training', 700)" 
                            class="w-full bg-green-500 text-white py-3 px-6 rounded-full font-semibold text-lg hover:bg-green-600 hover:transform hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                        Add to Cart
                    </button>
                </div>
            </div>
            
            <!-- Nutritional Guidelines Package -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="{{ asset('images/nutri.jpeg') }}" alt="Nutritional Guidelines" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Nutritional Guidelines</h3>
                    <div class="text-3xl font-bold text-green-600 mb-6">$700</div>
                    <button onclick="addToCart(3, 'Nutritional Guidelines', 700)" 
                            class="w-full bg-green-500 text-white py-3 px-6 rounded-full font-semibold text-lg hover:bg-green-600 hover:transform hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                        Add to Cart
                    </button>
                </div>
            </div>
            
            <!-- Diet Plan + Fitness Training Package -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="{{ asset('images/dietfit.webp') }}" alt="Diet Plan + Fitness Training" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Diet Plan + Fitness Training</h3>
                    <div class="text-3xl font-bold text-green-600 mb-6">$1000</div>
                    <button onclick="addToCart(4, 'Diet Plan + Fitness Training', 1000)" 
                            class="w-full bg-green-500 text-white py-3 px-6 rounded-full font-semibold text-lg hover:bg-green-600 hover:transform hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                        Add to Cart
                    </button>
                </div>
            </div>
            
            <!-- Nutritional Guidelines + Fitness Training Package -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="{{ asset('images/nutri-fitness.png') }}" alt="Nutritional Guidelines + Fitness Training" class="w-full h-full object-cover">

                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Nutritional Guidelines + Fitness Training</h3>
                    <div class="text-3xl font-bold text-green-600 mb-6">$1200</div>
                    <button onclick="addToCart(5, 'Nutritional Guidelines + Fitness Training', 1200)" 
                            class="w-full bg-green-500 text-white py-3 px-6 rounded-full font-semibold text-lg hover:bg-green-600 hover:transform hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                        Add to Cart
                    </button>
                </div>
            </div>
            
            <!-- All In One Package -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="{{ asset('images/allinone.jpeg') }}" alt="All in one" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">All In One Package</h3>
                    <div class="text-3xl font-bold text-green-600 mb-6">$1600</div>
                    <button onclick="addToCart(6, 'All In One Package', 1600)" 
                            class="w-full bg-green-500 text-white py-3 px-6 rounded-full font-semibold text-lg hover:bg-green-600 hover:transform hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
    });

    function addToCart(packageId, packageName, packagePrice) {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                package_id: packageId,
                package_name: packageName,
                package_price: packagePrice
            })
        })
        .then(response => {
            if (response.status === 401) {
                alert('Please sign in to add items to cart');
                window.location.href = '{{ route("login") }}';
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data && data.success) {
                alert('Package added to cart successfully!');
                updateCartCount();
            } else if (data && data.error) {
                alert(data.error);
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding package to cart');
        });
    }

    function updateCartCount() {
        fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            document.getElementById('cart-count').textContent = data.count || 0;
        });
    }
    </script>
@endsection