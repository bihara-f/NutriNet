<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Nutrinet Health Checkup Center')</title>

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    
    <!-- JavaScript -->
    <script>
        function myFunction() {
            var x = document.getElementById("navMenu");
            var content = x.querySelector('.nav-content');
            content.classList.toggle('show');
        }
    </script>
    
    <!-- Font Awesome & Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>
<body class="pt-20 font-nunito">
    <!-- Header - Tailwind CSS version -->
    <header class="bg-green-500 shadow-lg fixed top-0 left-0 right-0 z-50 py-4 transition-all duration-300 flex justify-between items-center">
        <div class="ml-8">
            <img src="{{ asset('images/logo-icon.png') }}" alt="logo" class="h-12 w-auto transition-all duration-300 hover:scale-105">
        </div>
        <nav class="mr-8" id="navMenu">
            <button class="md:hidden p-2 text-white hover:bg-white hover:bg-opacity-20 hover:text-green-500 transition-all duration-300 rounded" onclick="myFunction()">
                <i class="fa fa-bars text-xl"></i>
            </button>
            <div class="nav-content hidden md:flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="text-white no-underline font-medium text-base px-4 py-2 rounded-full transition-all duration-300 relative hover:text-black hover:bg-white hover:bg-opacity-20 transform hover:-translate-y-1 {{ request()->routeIs('dashboard') ? 'text-black bg-white bg-opacity-30' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="text-white no-underline font-medium text-base px-4 py-2 rounded-full transition-all duration-300 relative hover:text-black hover:bg-white hover:bg-opacity-20 transform hover:-translate-y-1 {{ request()->routeIs('about') ? 'text-black bg-white bg-opacity-30' : '' }}">About</a>
                <a href="{{ route('services') }}" class="text-white no-underline font-medium text-base px-4 py-2 rounded-full transition-all duration-300 relative hover:text-black hover:bg-white hover:bg-opacity-20 transform hover:-translate-y-1 {{ request()->routeIs('services') ? 'text-black bg-white bg-opacity-30' : '' }}">Services</a>
                <a href="{{ route('packages') }}" class="text-white no-underline font-medium text-base px-4 py-2 rounded-full transition-all duration-300 relative hover:text-black hover:bg-white hover:bg-opacity-20 transform hover:-translate-y-1 {{ request()->routeIs('packages') ? 'text-black bg-white bg-opacity-30' : '' }}">Packages</a>
                <a href="{{ route('cart') }}" class="text-white no-underline font-medium text-base px-4 py-2 rounded-full transition-all duration-300 relative hover:text-black hover:bg-white hover:bg-opacity-20 transform hover:-translate-y-1 {{ request()->routeIs('cart') ? 'text-black bg-white bg-opacity-30' : '' }}">Cart <i class="fa fa-shopping-cart"></i></a>
                <a href="{{ route('my.orders') }}" class="text-white no-underline font-medium text-base px-4 py-2 rounded-full transition-all duration-300 relative hover:text-black hover:bg-white hover:bg-opacity-20 transform hover:-translate-y-1 {{ request()->routeIs('my.orders') ? 'text-black bg-white bg-opacity-30' : '' }}">My Orders</a>
                <a href="{{ route('user.profile') }}" class="text-white no-underline font-medium text-base px-4 py-2 rounded-full transition-all duration-300 relative hover:text-black hover:bg-white hover:bg-opacity-20 transform hover:-translate-y-1 {{ request()->routeIs('user.profile') ? 'text-black bg-white bg-opacity-30' : '' }}">User Profile</a>
                <a href="{{ route('faq') }}" class="text-white no-underline font-medium text-base px-4 py-2 rounded-full transition-all duration-300 relative hover:text-black hover:bg-white hover:bg-opacity-20 transform hover:-translate-y-1 {{ request()->routeIs('faq') ? 'text-black bg-white bg-opacity-30' : '' }}">FAQ</a>
                
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <a href="{{ route('logout') }}" class="bg-white text-green-500 px-5 py-2 rounded-full font-semibold border-2 border-white cursor-pointer transition-all duration-300 hover:bg-green-500 hover:text-white transform hover:-translate-y-1 shadow-md hover:shadow-white/40" 
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            Logout &nbsp;<i class="fa fa-sign-out"></i>
                        </a>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-green-500 px-5 py-2 rounded-full font-semibold border-2 border-white cursor-pointer transition-all duration-300 hover:bg-green-500 hover:text-white transform hover:-translate-y-1 shadow-md hover:shadow-white/40 {{ request()->routeIs('login') ? 'bg-green-500 text-white' : '' }}">Sign-in &nbsp;<i class="fa fa-sign-in"></i></a>
                    <a href="{{ route('register') }}" class="bg-white text-green-500 px-5 py-2 rounded-full font-semibold border-2 border-white cursor-pointer transition-all duration-300 hover:bg-green-500 hover:text-white transform hover:-translate-y-1 shadow-md hover:shadow-white/40 {{ request()->routeIs('register') ? 'bg-green-500 text-white' : '' }}">Sign-up &nbsp;<i class="fa fa-user-plus"></i></a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer - Tailwind CSS version -->
    <footer class="bg-gradient-to-br from-slate-700 to-slate-800 text-white py-16 mt-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto px-5">
            <div>
                <a href="#"><img src="{{ asset('images/logo.png') }}" alt="logo" class="h-16 mb-5 brightness-0 invert"></a>
                <p class="text-gray-300 leading-relaxed">Nutrinet is a comprehensive online wellness hub committed to empowering individuals to enhance their health and well-being through personalized diet plans and proactive health monitoring.</p>
            </div>
            <div>
                <h3 class="text-xl font-semibold mb-6 text-white">Quick Links</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-green-400 transition-colors duration-300 hover:underline">Home</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-green-400 transition-colors duration-300 hover:underline">About Us</a></li>
                    <li><a href="{{ route('services') }}" class="text-gray-300 hover:text-green-400 transition-colors duration-300 hover:underline">Services</a></li>
                    <li><a href="{{ route('packages') }}" class="text-gray-300 hover:text-green-400 transition-colors duration-300 hover:underline">Packages</a></li>
                    <li><a href="{{ route('user.profile') }}" class="text-gray-300 hover:text-green-400 transition-colors duration-300 hover:underline">User Profile</a></li>
                    <li><a href="{{ route('faq') }}" class="text-gray-300 hover:text-green-400 transition-colors duration-300 hover:underline">FAQ</a></li>
                    @auth
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <a href="{{ route('logout') }}" class="text-gray-300 hover:text-green-400 transition-colors duration-300 hover:underline" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout &nbsp;<i class="fa fa-sign-out"></i>
                                </a>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-green-400 transition-colors duration-300 hover:underline">Sign-in &nbsp;<i class="fa fa-sign-in"></i></a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-green-400 transition-colors duration-300 hover:underline">Sign-up &nbsp;<i class="fa fa-user-plus"></i></a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-semibold mb-6 text-white">Follow us on</h3>
                <ul class="space-y-3">
                    <li class="flex items-center text-gray-300 hover:text-green-400 transition-colors duration-300 cursor-pointer"><i class="fa fa-facebook mr-2"></i> Facebook</li>
                    <li class="flex items-center text-gray-300 hover:text-green-400 transition-colors duration-300 cursor-pointer"><i class="fa fa-twitter mr-2"></i> Twitter</li>
                    <li class="flex items-center text-gray-300 hover:text-green-400 transition-colors duration-300 cursor-pointer"><i class="fa fa-instagram mr-2"></i> Instagram</li>
                    <li class="flex items-center text-gray-300 hover:text-green-400 transition-colors duration-300 cursor-pointer"><i class="fa fa-linkedin mr-2"></i> Linkedin</li>
                    <li class="flex items-center text-gray-300 hover:text-green-400 transition-colors duration-300 cursor-pointer"><i class="fa fa-youtube mr-2"></i> Youtube</li>
                </ul>
            </div>
        </div>
        <div class="text-center text-gray-400 mt-8 pt-8 border-t border-gray-600">
            Nutrinet Health Checkup Center&copy;2024 All rights reserved | Design by Dilara Waidyarathne
        </div>
    </footer>

    @stack('scripts')
</body>
</html>