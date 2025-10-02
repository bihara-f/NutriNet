@extends('layouts.app-old')

@section('title', 'About Us - Nutrinet Health Checkup Center')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/about_style.css') }}">
@endpush

@section('content')
    <!-- About Us Section - Exact from old semester -->
    <section class="about-us">
        <div class="left">
            <img src="{{ asset('images/about_us.jpg') }}" alt="team in a room">
        </div>
        <div class="right">
            <h2>About Us</h2>
            <p>Nutrinet Diet Plan and Health Checkup Center was founded in 2020 with a singular mission: to empower individuals to achieve their optimal health through personalized nutrition and comprehensive checkups. We believe that true well-being is a journey, not a destination, and we're here to be your guide every step of the way.Nutrinet Diet Plan and Health Checkup Center was founded in 2020 with a singular mission: to empower individuals to achieve their optimal health through personalized nutrition and comprehensive checkups. We believe that true well-being is a journey, not a destination, and we're here to be your guide every step of the way</p>
        </div>
    </section>
    
    <!-- Mission and Vision Section - Exact from old semester -->
    <section class="mission">
        <div class="container">
            <h3>Our Mission</h3>
            <p>At Nutrinet, our mission is to empower individuals to take control of their health through:Personalized Nutrition: We go beyond one-size-fits-all plans. Our registered dietitians create customized dietary programs that consider your individual health goals, dietary restrictions, and preferences.
                Comprehensive Health Checkups: We offer a wide range of health checkups, allowing you to gain a clear picture of your overall well-being.
                Education and Support: We believe knowledge is power. We provide ongoing education and support to help you make informed decisions about your health.</p>
        </div>
        <div class="container">
            <h3>Our Vision</h3>
            <p>At Nutrinet, our mission is to empower individuals to take control of their health through:Personalized Nutrition: We go beyond one-size-fits-all plans. Our registered dietitians create customized dietary programs that consider your individual health goals, dietary restrictions, and preferences.
                Comprehensive Health Checkups: We offer a wide range of health checkups, allowing you to gain a clear picture of your overall well-being.
                Education and Support: We believe knowledge is power. We provide ongoing education and support to help you make informed decisions about your health.</p>
        </div>
    </section>
@endsection