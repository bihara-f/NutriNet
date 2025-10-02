@extends('layouts.admin')

@section('title', 'Admin Settings')

@section('content')
<div class="middle">
    <div class="box" style="width: 100%; text-align: center;">
        <h2>Admin Settings</h2>
    </div>
</div>

<div class="bottom">
    <div class="form-container">
        <h3>Change Password</h3>
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            
            <label for="current_password">Current Password:</label>
            <input type="password" id="current_password" name="current_password" required>
            
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required minlength="8">
            
            <label for="new_password_confirmation">Confirm New Password:</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required minlength="8">
            
            <div class="form-btn">
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
    </div>

    <div class="form-container" style="margin-top: 30px;">
        <h3>Admin Information</h3>
        <div class="form-group">
            <label><strong>Name:</strong></label>
            <input type="text" value="{{ Auth::user()->name }}" readonly>
        </div>
        <div class="form-group">
            <label><strong>Email:</strong></label>
            <input type="email" value="{{ Auth::user()->email }}" readonly>
        </div>
        <div class="form-group">
            <label><strong>Account Created:</strong></label>
            <input type="text" value="{{ Auth::user()->created_at->format('d/m/Y H:i') }}" readonly>
        </div>
        <div class="form-group">
            <label><strong>Last Login:</strong></label>
            <input type="text" value="{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d/m/Y H:i') : 'N/A' }}" readonly>
        </div>
    </div>

    <div class="form-container" style="margin-top: 30px;">
        <h3>System Information</h3>
        <div class="form-group">
            <label><strong>Laravel Version:</strong></label>
            <input type="text" value="{{ app()->version() }}" readonly>
        </div>
        <div class="form-group">
            <label><strong>PHP Version:</strong></label>
            <input type="text" value="{{ PHP_VERSION }}" readonly>
        </div>
        <div class="form-group">
            <label><strong>Environment:</strong></label>
            <input type="text" value="{{ app()->environment() }}" readonly>
        </div>
    </div>
</div>
@endsection