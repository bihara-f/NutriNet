@extends('layouts.app-old')

@section('title', 'Nutrinet Health Checkup Center')

@section('content')
    <!-- Hero Section - Tailwind CSS version -->
    <section class="relative min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center" 
             style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('images/hero_bg.png') }}');">
        <div class="text-center px-8">
            <h2 class="text-6xl md:text-8xl font-bold text-white mb-4 leading-tight drop-shadow-2xl">Eat Healthy</h2>
            <h2 class="text-6xl md:text-8xl font-bold text-white mb-12 leading-tight drop-shadow-2xl">All Week Long</h2>
            @auth
                <a href="{{ route('payment') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold text-xl px-8 py-4 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl shadow-lg">
                    Start Diet Plan <i class="fa fa-calendar-check-o ml-2"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold text-xl px-8 py-4 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl shadow-lg">
                    Start Diet Plan <i class="fa fa-calendar-check-o ml-2"></i>
                </a>
            @endauth
        </div>
    </section>

    <!-- How it Works Section - Tailwind CSS version -->
    <section class="py-20 bg-gray-50">
        <div class="text-center mb-16">
            <h3 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                How it <span class="text-green-500">Works</span>
            </h3>
            <img src="{{ asset('images/underline.svg') }}" alt="line" class="mx-auto h-2">
        </div>
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105">
                <img src="{{ asset('images/diet-planner.jpg') }}" alt="nutritionist" class="w-full h-64 object-cover">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Start Diet Plan</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Embark on a transformative journey towards better health with our comprehensive diet plans. Our nutritionists will curate a personalized plan tailored to your unique dietary needs and goals. From balanced meals to smart snacking options, we'll guide you every step of the way, empowering you to make healthier choices and achieve lasting results.</p>
                    @auth
                        <a href="{{ route('packages') }}">
                            <button class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                Learn More &nbsp;<i class="fa fa-arrow-right"></i>
                            </button>
                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            <button class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                Learn More &nbsp;<i class="fa fa-arrow-right"></i>
                            </button>
                        </a>
                    @endauth
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105">
                <img src="{{ asset('images/schedule.jpg') }}" alt="meal plan" class="w-full h-64 object-cover">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Get Best Schedule</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Optimize your fitness journey with our expertly designed schedules. Our trainers will create a personalized plan tailored to your needs, ensuring every workout and meal fits seamlessly into your day. Stay motivated, accountable, and on track to reach your goals with our efficient and effective schedules.</p>
                    @auth
                        <a href="{{ route('packages') }}">
                            <button class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                Learn More &nbsp;<i class="fa fa-arrow-right"></i>
                            </button>
                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            <button class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                Learn More &nbsp;<i class="fa fa-arrow-right"></i>
                            </button>
                        </a>
                    @endauth
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105">
                <img src="{{ asset('images/enjoy-life.jpg') }}" alt="meal plan" class="w-full h-64 object-cover">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Enjoy Your Life</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Embrace balanced living with our holistic wellness approach. Our coaches will guide you in incorporating mindfulness, stress management, and self-care practices into your routine, fostering a happier, healthier lifestyle. Say goodbye to strict regimens and hello to a life filled with joy, balance, and fulfillment.</p>
                    @auth
                        <a href="{{ route('packages') }}">
                            <button class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                Learn More &nbsp;<i class="fa fa-arrow-right"></i>
                            </button>
                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            <button class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                Learn More &nbsp;<i class="fa fa-arrow-right"></i>
                            </button>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- About Section - Tailwind CSS version -->
    <section class="py-20 bg-white">
        <div id="about" class="max-w-7xl mx-auto px-8 flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-1/2">
                <img src="{{ asset('images/home-about.jpg') }}" alt="medical checkup" class="w-full h-auto rounded-2xl shadow-2xl transition-transform duration-300 hover:scale-105">
            </div>
            <div class="lg:w-1/2">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8 text-center lg:text-left">Who We Are</h2>
                <div class="text-gray-600 leading-relaxed space-y-6 text-lg">
                    <p>Nutrinet is not just a platform; it's a lifestyle revolution. At Nutrinet, we believe that true wellness extends beyond physical fitness to encompass mental and emotional well-being. Our team of experts is dedicated to providing holistic support to our community members, guiding them towards a balanced and fulfilling life. Whether you're looking to improve your fitness, manage stress, cultivate mindfulness, or enhance your nutrition, Nutrinet is here to support you every step of the way.</p>
                    
                    <p>We pride ourselves on offering personalized experiences tailored to each individual's unique needs and goals. Through our innovative tools and resources, we empower users to take control of their health journey and make sustainable changes that last a lifetime. From personalized workout plans and meal recommendations to mindfulness practices and stress-management techniques, Nutrinet offers a comprehensive approach to wellness that prioritizes your overall well-being.</p>
                    
                    <p>At Nutrinet, we understand that achieving optimal health is not just about reaching a specific weight or fitting into a certain dress size—it's about feeling confident, vibrant, and empowered in every aspect of your life. That's why we're committed to providing you with the tools, support, and inspiration you need to thrive, both inside and out. Join the Nutrinet community today and embark on a journey towards a happier, healthier you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Consultation Form Section - Tailwind CSS version -->
    @if(request()->get('notify') == 'success')
        <div class="bg-green-500 text-white text-center py-4 px-8 mx-4 rounded-lg shadow-lg font-semibold text-lg">
            Successfully Sent a Consultation Form!!
        </div>
    @elseif(!request()->get('notify') || request()->get('notify') == 'failed')
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <!-- Left Image -->
                <div class="hidden lg:block">
                    <img src="{{ asset('images/gym1.jpg') }}" alt="Gym" class="w-full h-full object-cover rounded-2xl shadow-2xl">
                </div>
                
                <!-- Center Form -->
                <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100">
                    <h1 class="text-4xl font-bold text-center text-gray-800 mb-4">Free Consultation</h1>
                    <p class="text-gray-600 text-center mb-8 text-lg">Call us at +94 70 3999 709 or fill out the form below to get started.</p>
                    
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="full_name" class="flex items-center text-gray-700 font-semibold mb-2 text-lg">
                                <i class="fa fa-user mr-2 text-green-500"></i> Full Name
                            </label>
                            <input type="text" name="full_name" placeholder="John Doe" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                        </div>
                        
                        <div>
                            <label for="email" class="flex items-center text-gray-700 font-semibold mb-2 text-lg">
                                <i class="fa fa-envelope mr-2 text-green-500"></i> E-mail
                            </label>
                            <input type="email" name="email" placeholder="john@example.com" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                        </div>
                        
                        <div>
                            <label for="subject" class="flex items-center text-gray-700 font-semibold mb-2 text-lg">
                                <i class="fa fa-folder mr-2 text-green-500"></i> Subject
                            </label>
                            <input type="text" name="subject" placeholder="Regarding about consultation" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                        </div>
                        
                        <div>
                            <label for="message" class="flex items-center text-gray-700 font-semibold mb-2 text-lg">
                                <i class="fa fa-send mr-2 text-green-500"></i> Message
                            </label>
                            <textarea name="message" placeholder="Your message...." required rows="4"
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg resize-none"></textarea>
                        </div>
                        
                        <div class="text-center pt-4">
                            <input type="submit" name="submit" value="Submit"
                                   class="bg-gradient-to-r from-green-500 to-blue-600 text-white px-12 py-4 rounded-full text-xl font-semibold shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 hover:from-green-600 hover:to-blue-700 cursor-pointer">
                        </div>
                    </form>
                </div>
                
                <!-- Right Image -->
                <div class="hidden lg:block">
                    <img src="{{ asset('images/gym2.jpg') }}" alt="Gym" class="w-full h-full object-cover rounded-2xl shadow-2xl">
                </div>
            </div>
        </section>
    @endif

    <!-- Bottom Image Section - Tailwind CSS version -->
    <section class="py-0">
        <div class="w-full">
            <img src="{{ asset('images/meals-week.jpg') }}" alt="Meals of the Week" 
                 class="w-full h-96 object-cover shadow-lg">
        </div>
    </section>
@endsection