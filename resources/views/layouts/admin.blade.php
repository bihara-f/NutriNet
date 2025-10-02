<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Nutrinet Health Checkup Center')</title>

    <!-- Admin CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <header class="header">
        <div class="brand">
            <img src="{{ asset('images/admin-logo.png') }}" alt="Admin Logo" class="brand-logo" style="height: 48px; width: auto; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
        </div>
        <nav class="navbar" id="navMenu">
            <div class="nav-content">
                <span class="admin-title" style="color: #fff; font-size: 18px; font-weight: bold;">Admin Panel</span>
                <form method="POST" action="{{ route('logout') }}" class="nav-item nav-button" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-item nav-button" style="background: #1e3a8a; border: none; cursor: pointer; color: #fff; padding: 8px 16px; border-radius: 5px; font-weight: bold;">
                        Logout &nbsp;<i class="fa fa-sign-out"></i>
                    </button>
                </form>
            </div>
        </nav>
    </header>
    
    <main>
        <div class="container">
            <div class="side-nav">
                <h2>Admin Dashboard</h2>
                <ul class="side-nav-bar">
                    <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                        <li class="side-nav-item {{ request()->routeIs('admin.dashboard') ? 'sub-active' : '' }}">
                            Dashboard
                        </li>
                    </a>
                    <a href="{{ route('admin.users') }}" class="side-nav-link">
                        <li class="side-nav-item {{ request()->routeIs('admin.users') ? 'sub-active' : '' }}">
                            Manage Users
                        </li>
                    </a>
                    <a href="{{ route('admin.packages') }}" class="side-nav-link">
                        <li class="side-nav-item {{ request()->routeIs('admin.packages*') ? 'sub-active' : '' }}">
                            Package Details
                        </li>
                    </a>
                    <a href="{{ route('admin.orders') }}" class="side-nav-link">
                        <li class="side-nav-item {{ request()->routeIs('admin.orders') ? 'sub-active' : '' }}">
                            Order Details
                        </li>
                    </a>
                    <a href="{{ route('admin.faqs') }}" class="side-nav-link">
                        <li class="side-nav-item {{ request()->routeIs('admin.faqs*') ? 'sub-active' : '' }}">
                            Manage FAQs
                        </li>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="side-nav-link">
                        <li class="side-nav-item {{ request()->routeIs('admin.settings') ? 'sub-active' : '' }}">
                            Settings
                        </li>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="side-nav-link">
                        @csrf
                        <li class="side-nav-item side-nav-logout" onclick="this.closest('form').submit()">
                            Logout &nbsp;<i class="fa fa-sign-out"></i>
                        </li>
                    </form>
                </ul>
            </div>
            
            <div class="content">
                <div class="top">
                    <div class="account">
                        <img src="{{ Auth::user()->profile_photo_url ?? asset('images/user.png') }}" alt="user avatar" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        <h3>{{ Auth::user()->name ?? 'Admin' }}</h3>
                    </div>
                    <div class="icons">
                        <i class="fa fa-bell"></i>
                        <i class="fa fa-cogs"></i>
                    </div>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </main>
    
    @stack('scripts')
    
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>