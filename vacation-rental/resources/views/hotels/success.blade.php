@extends('layouts.app')

@section('content')
    <div class="hero-wrap js-fullheight"
        style="margin-top: -25px; background-image: url('{{ asset('assets/images/room-1.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start"
                data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <h1 class="mb-4">Booked Successfully</h1>
                    <p><strong>Thank you for your booking. You have been logged out for security.</strong></p>
                    <p><strong>Amount Paid: Rs. {{ $price }}</strong></p>
                    <h1 class="mb-4"></h1>
                    <p><a href="{{ route('home') }}" class="btn btn-primary">Go Home</a> </p>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-success">
            <h4>Payment Successful! 🎉</h4>
            <p>Thank you for your booking. You have been logged out for security.</p>
            <p><strong>Amount Paid: Rs. {{ $price }}</strong></p>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="btn btn-primary">Login Again</a>
            <a href="{{ route('home') }}" class="btn btn-secondary">Return to Home</a>
        </div>
    </div>
@endsection --}}
