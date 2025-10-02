<!DOCTYPE html>
<html>
<head>
    <title>Payment - Nutrinet Health Checkup Center</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/payment_style.css') }}">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="brand">
            <img src="{{ asset('images/logo-icon.png') }}" alt="logo" class="brand-logo">
        </div>
        <nav class="navbar" id="navMenu">
            <button class="nav-toggle" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </button>

            <!--header-->
            <div class="nav-content">
                <a href="{{ route('dashboard') }}" class="nav-item">Home</a>
                <a href="{{ route('about') }}" class="nav-item">About</a>
                <a href="{{ route('services') }}" class="nav-item">Services</a>
                <a href="{{ route('packages') }}" class="nav-item">Packages</a>
                <a href="{{ route('user.profile') }}" class="nav-item">User Profile</a>
                <a href="{{ route('faq') }}" class="nav-item">FAQ</a>
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="nav-item nav-button">
                            Logout &nbsp;<i class="fa fa-sign-out"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-item nav-button">Sign-in &nbsp;<i class="fa fa-sign-in"></i></a>
                    <a href="{{ route('register') }}" class="nav-item nav-button">Sign-up &nbsp;<i class="fa fa-user-plus"></i></a>
                @endauth
            </div>
        </nav>
    </header>
    <main>
        <div class="payment-container">
            <form action="{{ route('payment.store') }}" method="post">
                @csrf
                <div class="raw">
                    <div class="col">
                        <h3 class="title">Billing Address</h3>
                        <div class="inputBox">
                            <span>Full Name</span>
                            <input type="text" name="fullname" placeholder="John Doe" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="inputBox">
                            <span>Email</span>
                            <input type="text" name="email" placeholder="Johndoe@example.com" value="{{ Auth::user()->email }}" required>
                        </div>
                        <div class="inputBox">
                            <span>Address</span>
                            <input type="text" name="address" placeholder="House no - street - location" required>
                        </div>
                        <div class="inputBox">
                            <span>Country</span>
                            <input type="text" name="country" placeholder="Sri Lanka" required>
                        </div>
                        <div class="inputBox">
                            <span>Zip Code</span>
                            <input type="text" name="zip_code" placeholder="91100" required>
                        </div>
                    </div>

                    <div class="col">
                        <h3 class="title">Payment</h3>
                        <div class="inputBox">
                            <span>Card Accepted</span>
                            <img src="{{ asset('images/card_img.png') }}">
                        </div>
                        <div class="inputBox">
                            <span>Card Number</span>
                            <input type="text" name="card_number" maxlength="19" placeholder="0000-0000-0000-0000" required>
                        </div>
                        <div class="inputBox">
                            <label for="expDate">Expiration Date:</label>
                            <input type="text" id="expDate" name="expiration_date" maxlength="5" pattern="\d{2}/\d{2}" placeholder="MM/YY" required>
                        </div>
                        <div class="inputBox">
                            <span>CVV</span>
                            <input type="text" name="cvv" placeholder="911" maxlength="4" required>
                        </div>
                    </div>
                    <div class="col">
                        <h3 class="title">Select Package</h3>
                        <div class="inputBox">
                            <span>Package</span>
                            <select name="package" required>
                                <option value="">Select a Package</option>
                                <option value="1">Diet Plan - 700 LKR</option>
                                <option value="2">Fitness Training - 700 LKR</option>
                                <option value="3">Nutritional Guidelines - 700 LKR</option>
                                <option value="4">Diet Plan + Fitness Training - 1000 LKR</option>
                                <option value="5">Nutritional Guidelines + Fitness Training - 1200 LKR</option>
                                <option value="6">All In One Package - 1600 LKR</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Proceed to checkup" class="submit-btn">  
            </form>
        </div>

        <!--footer-->
        <footer>
            <div class="container">
                <div class="left-content">
                    <a href="#"><img src="{{ asset('images/logo.png') }}" alt="logo"></a>
                    <p>Nutrinet is a comprehensive online wellness hub committed to empowering individuals to enhance their health and well-being through personalized diet plans and proactive health monitoring.</p>
                </div>
                <div class="center-content">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('services') }}">Services</a></li>
                        <li><a href="{{ route('packages') }}">Packages</a></li>
                        <li><a href="{{ route('user.profile') }}">User Profile</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                        @auth
                            <li><a href="{{ route('profile.show') }}">Settings</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Sign-in &nbsp;<i class="fa fa-sign-in"></i></a></li>
                            <li><a href="{{ route('register') }}">Sign-up &nbsp;<i class="fa fa-user-plus"></i></a></li>
                        @endauth
                    </ul>
                </div>
                <div class="right-content">
                    <h3>Follow us on</h3>
                    <ul class="social-icons">
                        <li><i class="fa fa-facebook"> Facebook</i></li>
                        <li><i class="fa fa-twitter"></i> Twitter</li>
                        <li><i class="fa fa-instagram"></i> Instagram</li>
                        <li><i class="fa fa-linkedin"></i> Linkedin</li>
                        <li><i class="fa fa-youtube"> Youtube</i></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                Nutrinet Health Checkup Center&copy;2024 All rights reserved | Designed by Minduli Nureka
            </div>
        </footer>
    </main>
</body>
</html>