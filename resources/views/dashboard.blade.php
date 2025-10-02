@extends('layouts.app-old')

@section('title', 'Nutrinet Health Checkup Center')

@section('content')
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h2 class="hero-text-1">Welcome {{ Auth::user()->name }}</h2>
                <h2 class="hero-text-2">Eat Healthy All Week Long</h2>
                <a href="{{ route('diet-plans') }}" class="hero-btn">Start Diet Plan <i class="fa fa-calendar-check-o"></i></a>
            </div>
        </section>

        <!-- User Profile Section -->
        <section id="profile" class="user-profile-section">
            <div class="heading-1">
                <h1>Your Profile</h1>
            </div>

            <div class="container">
                <!-- Profile Section -->
                <div class="profile-section">
                    <div class="profile-details">
                        <div class="profile-photo">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile Photo">
                            @else
                                <img src="{{ asset('images/user.png') }}" alt="Profile Photo">
                            @endif
                        </div>
                        <div class="edit-profile">
                            <a href="{{ route('diet-plans') }}">
                                <button><i class="fa fa-file-text"></i> Diet Plan Reports</button>
                            </a>
                        </div>
                        <div class="edit-profile">
                            <a href="{{ route('profile.show') }}">
                                <button><i class="fa fa-edit"></i> Edit Profile</button>
                            </a>
                        </div>
                        <div class="edit-profile">
                            <button onclick="confirmDelete()" class="delete-btn">
                                <i class="fa fa-trash-o"></i> Delete Account
                            </button>
                        </div>
                        <div class="edit-profile">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"><i class="fa fa-sign-out"></i> Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="info-section">
                    <div class="user-info">
                        <div class="info-item">
                            <strong>Name:</strong> {{ Auth::user()->name }}
                        </div>
                        <div class="info-item">
                            <strong>Email:</strong> {{ Auth::user()->email }}
                        </div>
                        <div class="info-item">
                            <strong>Member Since:</strong> {{ Auth::user()->created_at->format('F d, Y') }}
                        </div>
                        <div class="info-item">
                            <strong>Email Status:</strong> 
                            @if(Auth::user()->email_verified_at)
                                <span class="verified">Verified</span>
                            @else
                                <span class="unverified">Not Verified</span>
                            @endif
                        </div>
                        <div class="info-item">
                            <button onclick="location.href='#feedback'" class="form-button">Add Feedback</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="home-services">
            <div class="title">
                <h3>How it <span>Works</span></h3>
                <img src="{{ asset('images/underline.svg') }}" alt="line">
            </div>
            <div class="container">
                <div class="service-card">
                    <img src="{{ asset('images/diet-planner.jpg') }}" alt="nutritionist" class="service-image">
                    <h3 class="service-name">Start Diet Plan</h3>
                    <p class="service-desc">Embark on a transformative journey towards better health with our comprehensive diet plans. Our nutritionists will curate a personalized plan tailored to your unique dietary needs and goals.</p>
                    <a href="{{ route('diet-plans') }}">
                        <button class="service-btn">Learn More &nbsp;<i class="fa fa-arrow-right"></i></button>
                    </a>
                </div>
                <div class="service-card">
                    <img src="{{ asset('images/schedule.jpg') }}" alt="meal plan" class="service-image">
                    <h3 class="service-name">Get Best Schedule</h3>
                    <p class="service-desc">Optimize your fitness journey with our expertly designed schedules. Our trainers will create a personalized plan tailored to your needs, ensuring every workout and meal fits seamlessly into your day.</p>
                    <a href="{{ route('diet-plans') }}">
                        <button class="service-btn">Learn More &nbsp;<i class="fa fa-arrow-right"></i></button>
                    </a>
                </div>
                <div class="service-card">
                    <img src="{{ asset('images/enjoy-life.jpg') }}" alt="meal plan" class="service-image">
                    <h3 class="service-name">Enjoy Your Life</h3>
                    <p class="service-desc">Embrace balanced living with our holistic wellness approach. Our coaches will guide you in incorporating mindfulness, stress management, and self-care practices into your routine.</p>
                    <a href="#about">
                        <button class="service-btn">Learn More &nbsp;<i class="fa fa-arrow-right"></i></button>
                    </a>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="home-about">
            <div class="about-containter">
                <img src="{{ asset('images/home-about.jpg') }}" alt="medical checkup">
                <div class="about-info">
                    <h2>Who We Are</h2>
                    <p>Nutrinet is not just a platform; it's a lifestyle revolution. At Nutrinet, we believe that true wellness extends beyond physical fitness to encompass mental and emotional well-being. Our team of experts is dedicated to providing holistic support to our community members, guiding them towards a balanced and fulfilling life.
                        <br><br>
                        We pride ourselves on offering personalized experiences tailored to each individual's unique needs and goals. Through our innovative tools and resources, we empower users to take control of their health journey and make sustainable changes that last a lifetime.
                        <br><br>
                        At Nutrinet, we understand that achieving optimal health is not just about reaching a specific weight or fitting into a certain dress size—it's about feeling confident, vibrant, and empowered in every aspect of your life.</p>
                </div>
            </div>
        </section>

        <!-- Consultation Section -->
        <section id="feedback" class="consultant">
            <div class="left-consultant">
                <img src="{{ asset('images/gym1.jpg') }}" alt="consultation">
            </div>
            <div class="center-consultant">
                <h1>Free Consultation</h1>
                <p>Contact us or fill out the form below to get started with your personalized diet plan.</p>
                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="full_name"><i class="fa fa-user"></i> Full Name</label><br>
                        <input type="text" name="full_name" placeholder="Your Full Name" class="form-item" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="fa fa-envelope"></i> E-mail</label><br>
                        <input type="email" name="email" placeholder="your@example.com" class="form-item" value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="subject"><i class="fa fa-folder"></i> Subject</label><br>
                        <input type="text" name="subject" placeholder="Regarding consultation" class="form-item" required>
                    </div>
                    <div class="form-group">
                        <label for="message"><i class="fa fa-send"></i> Message</label><br>
                        <textarea name="message" class="form-item textarea" placeholder="Your message...." required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="form-submit-btn" name="submit" value="Send Message">
                    </div>
                </form>
            </div>
            <div class="right-consultant">
                <img src="{{ asset('images/gym2.jpg') }}" alt="consultation">
            </div>
        </section>

        <!-- Bottom Section -->
    <!-- Bottom Image Section - Exact from old semester -->
    <section class="home-bottom">
        <img src="{{ asset('images/meals-week.jpg') }}" alt="Meals of the Week">
    </section>
@endsection
