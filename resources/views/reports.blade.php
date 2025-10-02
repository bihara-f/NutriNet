<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports - Nutrinet Health Checkup Center</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/report_faq_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header_footer_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login_style.css') }}"> 
    <script src="{{ asset('js/script.js') }}"></script>
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
        <div class="nav-content">
            <a href="{{ route('dashboard') }}" class="nav-item active">Home</a>
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
    <div class="overlay">
        <section class="health-plan-form">
            @if($healthPlans->count() > 0)
                <div class='table-container'>
                    <h2>Health Plans</h2>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Health Plan</th>
                                <th>Plan ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($healthPlans as $plan)
                                <tr>
                                    <td>Health Plan Report</td>
                                    <td><a href='#' class='plan-id' data-plan-id='{{ $plan->id }}'>View Report</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No health plans found.</p>
            @endif
        </section>
    </div>
</main>

<!-- Modal for displaying additional details -->
<div id="healthPlanModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="planDetails"></div>
    </div>
</div>

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
        Nutrinet Health Checkup Center&copy;2024 All rights reserved | Design by Kavindu Vijayarathne
    </div>
</footer>

<script>
    // Get the modal
    var modal = document.getElementById("healthPlanModal");

    // Get all plan IDs
    var planIds = document.querySelectorAll(".plan-id");

    // Loop through each plan ID and attach a click event listener
    planIds.forEach(function(planId) {
        planId.addEventListener("click", function() {
            // Fetch additional details using AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Populate the modal with the fetched details
                        document.getElementById("planDetails").innerHTML = xhr.responseText;
                        modal.style.display = "block"; // Display the modal
                    } else {
                        console.error("Error fetching plan details: " + xhr.status);
                    }
                }
            };
            // Access the plan ID using the data attribute
            xhr.open("GET", "{{ route('reports.details') }}?plan_id=" + this.getAttribute('data-plan-id'), true);
            xhr.send();
        });
    });

    // Close the modal when the close button is clicked
    modal.querySelector(".close").addEventListener("click", function() {
        modal.style.display = "none";
    });

    // Close the modal when the user clicks outside of it
    window.addEventListener("click", function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
</script>

</body>
</html>