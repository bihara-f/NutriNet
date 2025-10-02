@extends('layouts.app-old')

@section('title', 'User Profile - Nutrinet Health Checkup Center')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/account.css') }}">
@endpush

@section('content')
    <!--body content-->
    <div>
        <div class="heading-1">
            <h1>Your Profile</h1>
        </div>

        <div class="container">
            <!-- Profile Section -->
            <div class="profile-section">
                <div class="profile-details">
                    <div class="profile-photo">
                        <img src="{{ asset('images/user.png') }}" alt="Profile Photo">
                    </div>
                    <div class="edit-profile">
                        <a href="{{ route('reports') }}"><button><i class="fa fa-file-text"></i> Health Plan Reports</button></a>
                    </div>
                    <div class="edit-profile">
                        <a href="#"><button><i class="fa fa-edit"></i> Edit</button></a>
                    </div>
                    <div class="edit-profile">
                        <a href="#" onclick="return confirm('Are you sure you want to delete your account?')"><button><i class="fa fa-trash-o"></i> Delete Account</button></a>
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
                        First Name: {{ Auth::user()->name ?? 'N/A' }}
                    </div>
                    <div class="info-item">
                        Last Name: {{ 'N/A' }}
                    </div>
                    <div class="info-item">
                        Email: {{ Auth::user()->email ?? 'N/A' }}
                    </div>
                    <div class="info-item">
                        Contact Number: {{ 'N/A' }}
                    </div>
                    <div class="info-item">
                        Gender: {{ 'N/A' }}
                    </div>
                    <div class="info-item">
                        <button onclick="location.href='#'" class="form-button">Add Feedback</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection