@extends('layouts.app-old')

@section('title', 'Services - Nutrinet Health Checkup Center')

@section('content')

<!-- Hero Section - Tailwind CSS -->
<section class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center" 
         style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/header-hero@2x.jpg') }}');">
    <div class="text-center text-white px-8">
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6">Take care of your Health</h1>
        <p class="text-xl md:text-2xl lg:text-3xl leading-relaxed">
            Learn more about the various<br> 
            offered by our website and <br> 
            we provide you with world <br> 
            class care
        </p>
    </div>
</section>

<!-- Services Title Section - Tailwind CSS -->
<section class="py-20 bg-white">
    <div class="text-center">
        <h1 class="text-5xl md:text-6xl font-bold text-gray-800">Services</h1>
    </div>
</section>

<!-- Diet Planning Service - Tailwind CSS -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-8">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8 text-center">Diet Planning</h1>
            <div class="flex flex-col lg:flex-row items-center gap-8">
                <div class="lg:w-1/2">
                    <img src="{{ asset('images/diet_plan.jpg') }}" alt="Diet Planning" 
                         class="w-full h-auto rounded-2xl shadow-lg">
                </div>
                <div class="lg:w-1/2">
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Hey there! Are you looking for a way to eat healthier and live a happier life? Well, look no further! We are here to help you achieve your health goals! Our team of friendly experts will work closely with you to create personalized meal plans that take into account your goals, preferences, and any health concerns you may have. We'll be there to support and motivate you every step of the way, so you can succeed and feel your best! But don't just take our word for it - hear from our happy clients who have transformed their lives with our help! So, why not get in touch today to find out more or to book a consultation? We can't wait to help you on your journey towards a healthier, happier you!
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fit Training Service - Tailwind CSS -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-8">
        <div class="bg-gray-50 rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8 text-center">Fit Training</h1>
            <div class="flex flex-col lg:flex-row-reverse items-center gap-8">
                <div class="lg:w-1/2">
                    <img src="{{ asset('images/Dumbbells.jpeg') }}" alt="Fit Training" 
                         class="w-full h-auto rounded-2xl shadow-lg">
                </div>
                <div class="lg:w-1/2">
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Looking for an exciting way to start your fitness journey? Look no further! Our gym offers a range of training options that are guaranteed to get you moving and grooving. Our experienced team of trainers is always on hand to guide you through every step of the way. With our effective approach to fitness, you'll be amazed at the real results our clients achieve. We offer a variety of membership options, so you're sure to find the perfect fit for you. Don't hesitate to get in touch - we'd be delighted to provide you with more information. Let's get started on your journey to a healthier, happier you!
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nutrition Guidelines Service - Tailwind CSS -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-8">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8 text-center">Nutrition Guidelines</h1>
            <div class="flex flex-col lg:flex-row items-center gap-8">
                <div class="lg:w-1/2">
                    <img src="{{ asset('images/clip_dumbell.jpeg') }}" alt="Nutrition Guidelines" 
                         class="w-full h-auto rounded-2xl shadow-lg">
                </div>
                <div class="lg:w-1/2">
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Hey there! Are you looking for a way to eat healthier and live a happier life? Well, look no further! We are here to help you achieve your health goals! Our team of friendly experts will work closely with you to create personalized meal plans that take into account your goals, preferences, and any health concerns you may have. We'll be there to support and motivate you every step of the way, so you can succeed and feel your best! But don't just take our word for it - hear from our happy clients who have transformed their lives with our help! So, why not get in touch today to find out more or to book a consultation? We can't wait to help you on your journey towards a healthier, happier you!
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection