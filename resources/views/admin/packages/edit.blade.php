@extends('layouts.admin')

@section('title', 'Edit Package')

@section('content')
<div class="middle">
    <div class="box" style="width: 100%; text-align: center;">
        <h2>Edit Package: {{ $package->package_name }}</h2>
    </div>
</div>

<div class="bottom">
    <div class="form-container">
        <form method="POST" action="{{ route('admin.packages.update', $package) }}">
            @csrf
            @method('PUT')
            
            <label for="package_name">Package Name:</label>
            <input type="text" id="package_name" name="package_name" value="{{ old('package_name', $package->package_name) }}" required>
            
            <label for="package_price">Package Price (LKR):</label>
            <input type="number" id="package_price" name="package_price" step="0.01" min="0" value="{{ old('package_price', $package->package_price) }}" required>
            
            <label for="package_description">Description:</label>
            <textarea id="package_description" name="package_description" rows="4" placeholder="Package description...">{{ old('package_description', $package->package_description) }}</textarea>
            
            <div class="form-btn">
                <a href="{{ route('admin.packages') }}" class="btn" style="background-color: var(--gray); color: white; text-decoration: none;">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Package</button>
            </div>
        </form>
    </div>
</div>
@endsection