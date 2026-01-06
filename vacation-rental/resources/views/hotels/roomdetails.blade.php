@extends('layouts.app')

@section('content')
    <div class="hero-wrap js-fullheight"
        style="margin-top: -25px; background-image: url('{{ asset('assets/images/room-1.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start"
                data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <h2 class="subheading">Welcome to Vacation Rental</h2>
                    <h1 class="mb-4">{{ $getRoom->name }} </h1>
                    <!-- <p><a href="#" class="btn btn-primary">Learn more</a> <a href="#" class="btn btn-white">Contact us</a></p> -->
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @if (session()->has('error'))
            <div class="alert alert-success">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>

    <div class="container">
        @if (session()->has('error_dates'))
            <div class="alert alert-success">
                {{ session()->get('error_dates') }}
            </div>
        @endif
    </div>

    <section class="ftco-section ftco-book ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-4">
                    <form action="{{ route('hotel.rooms.booking', $getRoom->id) }}" method="post" class="appointment-form"
                        style="margin-top: -568px;">
                        @csrf
                        <h3 class="mb-3">Book this room</h3>
                        <div class="row">
                            <!-- Email -->
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="">
                                    <label for="email">Email ID</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Full Name -->
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" placeholder="">
                                    <label for="name">Full Name</label>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-12">
                                <div class="mb-3 position-relative">
                                    <div class="input-group">
                                        <select class="form-select" id="country_code" name="country_code"
                                            style="max-width: 120px; border-top-right-radius: 0; border-bottom-right-radius: 0;"
                                            required>
                                            <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }}>🇺🇸
                                                +1</option>
                                            <option value="+91" {{ old('country_code') == '+91' ? 'selected' : '' }}>
                                                🇮🇳 +91</option>
                                            <option value="+44" {{ old('country_code') == '+44' ? 'selected' : '' }}>
                                                🇬🇧 +44</option>
                                            <option value="+61" {{ old('country_code') == '+61' ? 'selected' : '' }}>
                                                🇦🇺 +61</option>
                                            <option value="+81" {{ old('country_code') == '+81' ? 'selected' : '' }}>
                                                🇯🇵 +81</option>
                                            <option value="+86" {{ old('country_code') == '+86' ? 'selected' : '' }}>
                                                🇨🇳 +86</option>
                                            <option value="+49" {{ old('country_code') == '+49' ? 'selected' : '' }}>
                                                🇩🇪 +49</option>
                                            <option value="+33" {{ old('country_code') == '+33' ? 'selected' : '' }}>
                                                🇫🇷 +33</option>
                                        </select>
                                        <input id="phone_number" type="text"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            name="phone_number" value="{{ old('phone_number') }}" required
                                            autocomplete="tel" placeholder="Phone Number" maxlength="10" pattern="[0-9]+"
                                            title="Please enter only numbers"
                                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                        <label for="phone_number" class="floating-label position-absolute text-muted"
                                            style="left: 130px; top: 50%; transform: translateY(-50%); transition: all 0.2s ease-in-out; pointer-events: none; z-index: 5; padding: 0 4px;">Phone
                                            Number</label>
                                    </div>
                                </div>
                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('country_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Check-in and Check-out side by side -->
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="input-wrap">
                                            <div class="icon"><span class="ion-md-calendar"></span></div>
                                            <label for="check-in">Check In</label>
                                            <input id="check-in" type="text"
                                                class="form-control appointment_date-check-in @error('check_in') is-invalid @enderror"
                                                name="check_in" value="{{ old('check_in') }}" required placeholder=""
                                                autocomplete="off">
                                        </div>
                                        @error('check_in')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="input-wrap">
                                            <div class="icon"><span class="ion-md-calendar"></span></div>
                                            <label for="check-in">Check Out</label>
                                            <input id="check-out" type="text"
                                                class="form-control appointment_date-check-out @error('check_out') is-invalid @enderror"
                                                name="check_out" value="{{ old('check_out') }}" required placeholder=""
                                                autocomplete="off">
                                        </div>
                                        @error('check_out')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12">
                            <div class="form-group">
                                @if (isset(Auth::user()->id))
                                    <input type="submit" value="Book and Pay Now" class="btn btn-primary py-3 px-4">
                                @else
                                    <p class="alert alert-success">PLease Login to book a room</p>
                                @endif
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-6 wrap-about">
                    <div class="img img-2 mb-4"
                        style="background-image: url( {{ asset('assets/images/image_2.jpg') }} );">
                    </div>
                    <h2>The most recommended vacation rental</h2>
                    <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a
                        paradisematic country, in which roasted parts of sentences fly into your mouth. Even the
                        all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One
                        day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World
                        of Grammar.</p>
                </div>
                <div class="col-md-6 wrap-about ftco-animate">
                    <div class="heading-section">
                        <div class="pl-md-5">
                            <h2 class="mb-2">What we offer</h2>
                        </div>
                    </div>
                    <div class="pl-md-5">
                        <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It
                            is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
                        <div class="row">
                            <div class="services-2 col-lg-6 d-flex w-100">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="flaticon-diet"></span>
                                </div>
                                <div class="media-body pl-3">
                                    <h3 class="heading">Tea Coffee</h3>
                                    <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                                </div>
                            </div>
                            <div class="services-2 col-lg-6 d-flex w-100">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="flaticon-workout"></span>
                                </div>
                                <div class="media-body pl-3">
                                    <h3 class="heading">Hot Showers</h3>
                                    <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                                </div>
                            </div>
                            <div class="services-2 col-lg-6 d-flex w-100">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="flaticon-diet-1"></span>
                                </div>
                                <div class="media-body pl-3">
                                    <h3 class="heading">Laundry</h3>
                                    <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                                </div>
                            </div>
                            <div class="services-2 col-lg-6 d-flex w-100">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="flaticon-first"></span>
                                </div>
                                <div class="media-body pl-3">
                                    <h3 class="heading">Air Conditioning</h3>
                                    <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                                </div>
                            </div>
                            <div class="services-2 col-lg-6 d-flex w-100">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="flaticon-first"></span>
                                </div>
                                <div class="media-body pl-3">
                                    <h3 class="heading">Free Wifi</h3>
                                    <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                                </div>
                            </div>
                            <div class="services-2 col-lg-6 d-flex w-100">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="flaticon-first"></span>
                                </div>
                                <div class="media-body pl-3">
                                    <h3 class="heading">Kitchen</h3>
                                    <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                                </div>
                            </div>
                            <div class="services-2 col-lg-6 d-flex w-100">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="flaticon-first"></span>
                                </div>
                                <div class="media-body pl-3">
                                    <h3 class="heading">Ironing</h3>
                                    <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                                </div>
                            </div>
                            <div class="services-2 col-lg-6 d-flex w-100">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="flaticon-first"></span>
                                </div>
                                <div class="media-body pl-3">
                                    <h3 class="heading">Lovkers</h3>
                                    <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-intro" style="background-image: url({{ asset('assets/images/image_2.jpg') }} );">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 text-center">
                    <h2>Ready to get started</h2>
                    <p class="mb-4">It’s safe to book online with us! Get your dream stay in clicks or drop us a line
                        with your questions.</p>
                    <p class="mb-0"><a href="#" class="btn btn-primary px-4 py-3">Learn More</a> <a
                            href="#" class="btn btn-white px-4 py-3">Contact us</a></p>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countryCodeSelect = document.getElementById('country_code');
            const phoneNumberInput = document.getElementById('phone_number');

            // Add CSS for floating label
            const style = document.createElement('style');
            style.textContent = `
                .floating-label {
                    transition: all 0.2s ease-in-out;
                    background-color: white;
                    padding: 0 4px;
                }
                .input-group:focus-within .floating-label {
                    color: #0d6efd !important;
                }
            `;
            document.head.appendChild(style);

            // Country code to expected phone number length mapping
            const phoneLengths = {
                '+1': 10, // USA
                '+91': 10, // India
                '+44': 10, // UK (simplified)
                '+61': 9, // Australia
                '+81': 10, // Japan (simplified)
                '+86': 11, // China
                '+49': 10, // Germany (simplified)
                '+33': 9 // France
            };

            function validatePhoneNumber() {
                const selectedCountry = countryCodeSelect.value;
                const expectedLength = phoneLengths[selectedCountry];
                const phoneValue = phoneNumberInput.value.replace(/\D/g, ''); // Remove non-digits

                if (phoneValue.length > 0 && phoneValue.length !== expectedLength) {
                    phoneNumberInput.setCustomValidity(
                        `Phone number must be ${expectedLength} digits for the selected country`);
                    phoneNumberInput.classList.add('is-invalid');
                } else {
                    phoneNumberInput.setCustomValidity('');
                    phoneNumberInput.classList.remove('is-invalid');
                }
            }

            // Validate on country code change
            countryCodeSelect.addEventListener('change', validatePhoneNumber);

            // Validate on phone number input
            phoneNumberInput.addEventListener('input', function() {
                // Allow only numbers
                this.value = this.value.replace(/\D/g, '');
                validatePhoneNumber();
            });

            // Validate on form submit
            const form = document.querySelector('.appointment-form');
            form.addEventListener('submit', function(e) {
                validatePhoneNumber();
                if (!phoneNumberInput.checkValidity()) {
                    e.preventDefault();
                    phoneNumberInput.reportValidity();
                }
            });

            // Floating label functionality for phone number
            const phoneLabel = document.querySelector('label[for="phone_number"]');

            function updateLabelPosition() {
                if (phoneNumberInput.value.trim() !== '' || phoneNumberInput === document.activeElement) {
                    phoneLabel.style.top = '0';
                    phoneLabel.style.transform = 'translateY(-50%) scale(0.85)';
                    phoneLabel.style.color = '#6c757d';
                } else {
                    phoneLabel.style.top = '50%';
                    phoneLabel.style.transform = 'translateY(-50%) scale(1)';
                    phoneLabel.style.color = '#6c757d';
                }
            }

            phoneNumberInput.addEventListener('focus', updateLabelPosition);
            phoneNumberInput.addEventListener('blur', updateLabelPosition);
            phoneNumberInput.addEventListener('input', updateLabelPosition);

            // Initial check
            updateLabelPosition();
        });
    </script>
@endsection
