@extends('layouts.app-old')

@section('title', 'Sign in - Nutrinet Health Checkup Center')

@section('content')
    <!-- Sign in Form - Tailwind CSS version -->
    <div class="min-h-screen bg-cover bg-center bg-no-repeat py-20 px-4" 
         style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('images/login-bg.jpg') }}');">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-8">Login to your account</h2>
                
                <form method="POST" action="{{ route('signin.post') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="username" class="flex items-center text-gray-700 font-semibold mb-3 text-lg">
                            <i class="fa fa-user mr-3 text-green-500"></i>
                            Username / E-mail
                        </label>
                        <input type="text" id="username" name="username" placeholder="Username or Email" 
                               value="{{ old('username') }}" required
                               class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                    </div>
                    
                    <div>
                        <label for="password" class="flex items-center text-gray-700 font-semibold mb-3 text-lg">
                            <i class="fa fa-key mr-3 text-green-500"></i>
                            Password
                        </label>
                        <input type="password" id="password" name="password" placeholder="Password" required
                               class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                        <a href="#" class="text-green-600 hover:text-green-700 text-sm font-medium mt-2 inline-block">Forgot Password?</a>
                    </div>
                    
                    <div class="pt-4">
                        <button type="submit" name="submit"
                                class="w-full bg-gradient-to-r from-green-500 to-blue-600 text-white py-4 rounded-full text-xl font-semibold shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 hover:from-green-600 hover:to-blue-700">
                            Submit
                        </button>
                    </div>
                    
                    @if ($errors->has('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-center">
                            @if ($errors->first('error') == 'emptycredentials')
                                Fill the all fields!!
                            @elseif ($errors->first('error') == 'stmtfailed')
                                Database Connection Lost. Try again later
                            @elseif ($errors->first('error') == 'invalidusername')
                                Invalid username, Please enter valid username
                            @elseif ($errors->first('error') == 'invalidpassword')
                                Invalid Password, Please enter correct password
                            @endif
                        </div>
                    @endif
                </form>
                
                <hr class="my-8 border-gray-300">
                <p class="text-center text-gray-600 text-lg">
                    New to the site? 
                    <a href="{{ route('registration') }}" class="text-green-600 hover:text-green-700 font-semibold">Sign up</a>
                </p>
            </div>
        </div>
    </div>
@endsection