@extends('layouts.app-old')

@section('title', 'Payment - Nutrinet Health Checkup Center')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/payment_style.css') }}">
@endpush

@section('content')
<main>
    <div class="payment-container">
        <form action="{{ url()->current() }}" method="post">
            @csrf
            <div class="raw">
                <div class="col">
                    <h3 class="title">Billing Address</h3>
                    <div class="inputBox">
                        <span>Full Name</span>
                        <input type="text" name="fullname" placeholder="John Doe" required>
                    </div>
                    <div class="inputBox">
                        <span>Email</span>
                        <input type="text" name="email" placeholder="Johndoe@example.com" required>
                    </div>
                    <div class="inputBox">
                        <span>Address</span>
                        <input type="text" name="address" placeholder="House no - street - location" required>
                    </div>
                    <div class="inputBox">
                        <span>Country</span>
                        <input type="text" name="country" placeholder="Sri Lanka" required>
                    </div>
                    <div class="inputBox">
                        <span>Zip Code</span>
                        <input type="text" name="zip_code" placeholder="91100" required>
                    </div>
                </div>

                <div class="col">
                    <h3 class="title">Payment</h3>
                    <div class="inputBox">
                        <span>Card Accepted</span>
                        <img src="{{ asset('images/card_img.png') }}">
                    </div>
                    <div class="inputBox">
                        <span>Card Number</span>
                        <input type="text" name="card_number" maxlength="19" placeholder="0000-0000-0000-0000" required>
                    </div>
                    <div class="inputBox">
                        <label for="expDate">Expiration Date:</label>
                        <input type="text" id="expDate" name="expiration_date" maxlength="5" pattern="\d{2}/\d{2}" placeholder="MM/YY" required>
                    </div>
                    <div class="inputBox">
                        <span>CVV</span>
                        <input type="text" name="cvv" placeholder="911" required>
                    </div>
                </div>
                <div class="col">
                    <h3 class="title">Order Summary</h3>
                    @php
                        $cart = session()->get('cart', []);
                        $total = 0;
                    @endphp
                    
                    @if(!empty($cart))
                        @foreach($cart as $id => $item)
                            @php $total += $item['price'] * $item['quantity']; @endphp
                            <div class="inputBox">
                                <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                <input type="hidden" name="cart_items[{{ $id }}][id]" value="{{ $item['id'] }}">
                                <input type="hidden" name="cart_items[{{ $id }}][name]" value="{{ $item['name'] }}">
                                <input type="hidden" name="cart_items[{{ $id }}][price]" value="{{ $item['price'] }}">
                                <input type="hidden" name="cart_items[{{ $id }}][quantity]" value="{{ $item['quantity'] }}">
                            </div>
                        @endforeach
                        <div class="inputBox">
                            <strong>Total: ${{ number_format($total, 2) }}</strong>
                        </div>
                    @else
                        <div class="inputBox">
                            <span>No items in cart</span>
                            <a href="{{ route('packages') }}" style="color: #4CAF50;">Add some packages first</a>
                        </div>
                    @endif
                </div>
            </div>
            <input type="submit" value="Proceed to checkup" class="submit-btn">  
        </form>
    </div>

    @if(session('payment_success'))
        <script>
            alert('Payment successful!');
            window.location.href = "{{ route('profile.show') }}";
        </script>
    @endif

    @if(session('payment_error'))
        <script>
            alert('Payment failed. Please try again.');
        </script>
    @endif
</main>
@endsection