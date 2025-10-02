@extends('layouts.admin')

@section('title', 'Add New Package')

@section('content')
<div class="middle">
    <div class="box" style="width: 100%; text-align: center;">
        <h2>Add New Package</h2>
    </div>
</div>

<div class="bottom">
    <div class="form-container">
        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-error" style="background-color: #fee; border: 1px solid #fcc; color: #c66; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Display success message -->
        @if (session('error'))
            <div class="alert alert-error" style="background-color: #fee; border: 1px solid #fcc; color: #c66; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.packages.store') }}">
            @csrf
            
            <label for="package_name">Package Name:</label>
            <input type="text" id="package_name" name="package_name" value="{{ old('package_name') }}" required 
                   class="@error('package_name') error @enderror">
            
            <label for="package_price">Package Price (LKR):</label>
            <input type="number" id="package_price" name="package_price" step="0.01" min="0" max="9999999.99" value="{{ old('package_price') }}" required 
                   style="background: white !important; pointer-events: auto !important;" 
                   placeholder="Enter price (e.g., 5000.00) - Max: 9,999,999.99"
                   onfocus="this.style.backgroundColor='#f9f9f9'"
                   onblur="this.style.backgroundColor='white'"
                   class="@error('package_price') error @enderror">
            
            <label for="package_description">Description:</label>
            <textarea id="package_description" name="package_description" rows="4" placeholder="Package description..." 
                      class="@error('package_description') error @enderror">{{ old('package_description') }}</textarea>
            
            <div class="form-btn">
                <a href="{{ route('admin.packages') }}" class="btn" style="background-color: var(--gray); color: white; text-decoration: none;">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Package</button>
            </div>
        </form>
    </div>
</div>

<style>
.form-container .error {
    border-color: #ff6b6b !important;
    background-color: #ffe6e6 !important;
}

.alert {
    border-radius: 5px;
    padding: 12px 15px;
    margin-bottom: 20px;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

.alert li {
    margin-bottom: 5px;
}
</style>

<script>
// Ensure price input is fully interactive
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('package_price');
    
    if (priceInput) {
        // Remove any potential readonly or disabled attributes
        priceInput.removeAttribute('readonly');
        priceInput.removeAttribute('disabled');
        
        // Add event listeners to ensure functionality
        priceInput.addEventListener('input', function(e) {
            console.log('Price input changed:', e.target.value);
        });
        
        priceInput.addEventListener('focus', function(e) {
            e.target.style.borderColor = '#007bff';
            e.target.style.backgroundColor = '#f8f9fa';
        });
        
        priceInput.addEventListener('blur', function(e) {
            e.target.style.borderColor = '#ddd';
            e.target.style.backgroundColor = 'white';
        });
        
        // Test if input is working
        console.log('Price input initialized successfully');
    }
});
</script>
@endsection