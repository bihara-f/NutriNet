@extends('layouts.app-old')

@section('title', 'Registration - Nutrinet Health Checkup Center')

@section('content')
    <!-- Registration Form - Tailwind CSS version -->
    <div class="min-h-screen bg-gray-50 py-20 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-10">Sign up</h2>

                <form method="POST" action="{{ route('registration.post') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="firstname" class="block text-gray-700 font-semibold mb-2 text-lg">First Name</label>
                            <input type="text" id="firstname" name="firstname" placeholder="John" 
                                   value="{{ old('firstname') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                        </div>
                          
                        <div>
                            <label for="lastname" class="block text-gray-700 font-semibold mb-2 text-lg">Last Name</label>
                            <input type="text" id="lastname" name="lastname" placeholder="Clarke" 
                                   value="{{ old('lastname') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-gray-700 font-semibold mb-2 text-lg">E-mail</label>
                            <input type="email" id="email" name="email" placeholder="JohnClarke@gmail.com" 
                                   value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                        </div>

                        <div>
                            <label for="contact" class="block text-gray-700 font-semibold mb-2 text-lg">Contact No.</label>
                            <input type="text" id="contact" name="contact" placeholder="+94 xxx xxx xxx" 
                                   value="{{ old('contact') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                        </div>
                    </div>

                    <div>
                        <label for="username" class="block text-gray-700 font-semibold mb-2 text-lg">Username</label>
                        <input type="text" id="username" name="username" placeholder="Type Here" 
                               value="{{ old('username') }}" required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-gray-700 font-semibold mb-2 text-lg">Password</label>
                            <input type="password" id="password" name="password" placeholder="Type Here" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                        </div>

                        <div>
                            <label for="confirmPassword" class="block text-gray-700 font-semibold mb-2 text-lg">Confirm password</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Type Here" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg">
                        </div>
                    </div>

                    <div>
                        <label for="gender" class="block text-gray-700 font-semibold mb-2 text-lg">Gender</label>
                        <select id="gender" name="gender" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors duration-300 text-lg bg-white">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center gap-3 py-4">
                        <input type="checkbox" required class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <span class="text-gray-700 text-lg">I hereby agree with the terms & conditions</span>
                    </div>
                      
                    <div class="pt-4">
                        <button type="submit" name="submit"
                                class="w-full bg-gradient-to-r from-green-500 to-blue-600 text-white py-4 rounded-full text-xl font-semibold shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 hover:from-green-600 hover:to-blue-700">
                            Register
                        </button>
                    </div>
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection