@extends('layouts.app')

@section('content')
    <div class="hero-wrap js-fullheight"
        style="margin-top: -25px; background-image: url('{{ asset('assets/images/room-1.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start"
                data-scrollax-parent="true">
                <div class="col-md-12 ftco-animate">
                    <h1 style="margin-left: 200px" class="subheading">Pay with PayPal</h1>

                    <div class="col-md-6 text-center">
                        <h3 class="mb-4 text-white">Amount: Rs. {{ Session::get('price', 0.0) }}</h3>
                    </div>
                    {{-- <p><a href="{{ route('home') }}" class="btn btn-primary">Go Home</a></p> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Replace "test" with your own sandbox Business account app client ID -->
        <script
            src="https://www.paypal.com/sdk/js?client-id=ARbKJ2qFgHQaIDl-ZntKVkuo_VFuFlGgy5jXg_kfopFUxdRJ_SWVGe4G6nd9U4CZNcKu_VuzX_WhC9_q&currency=USD">
        </script>

        {{-- new sdk --}}
        {{-- <script
            src="https://www.paypal.com/sdk/js?client-id=ARbKJ2qFgHQaIDl-ZntKVkuo_VFuFlGgy5jXg_kfopFUxdRJ_SWVGe4G6nd9U4CZNcKu_VuzX_WhC9_q&currency=USD&buyer-country=US&intent=capture&commit=false&disable-funding=credit,card,venmo">
        </script> --}}

        <!-- Set up a container element for the button -->
        <div style="margin-top: -220px; margin-left: 100px;" id="paypal-button-container"></div>

        {{-- original --}}
        <script>
            // function clearPayPalSession() {
            //     // Clear all cookies for PayPal domains
            //     const domains = ['.paypal.com', '.sandbox.paypal.com'];
            //     domains.forEach(domain => {
            //         document.cookie.split(";").forEach(function(c) {
            //             document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date()
            //                 .toUTCString() + ";path=/;domain=" + domain);
            //         });
            //     });

            //     // Clear storage
            //     localStorage.clear();
            //     sessionStorage.clear();
            //     alert('Session cleared! You can now test with a fresh login.');
            // }


            paypal.Buttons({
                createOrder: (data, actions) => {
                    // Get the price from session
                    const price = '{{ Session::get('price') }}';

                    // Check if price is valid
                    if (!price || price === '' || isNaN(parseFloat(price))) {
                        alert('Payment amount is not set. Please try booking again.');
                        return false;
                    }

                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: price,
                                currency_code: 'USD'
                            }
                        }]
                    });
                },
                onApprove: (data, actions) => {
                    return actions.order.capture().then(function(orderData) {
                        window.location.href = 'http://127.0.0.1:8000/hotels/success';
                    });
                },
                onError: (err) => {
                    console.error('PayPal Error:', err);
                    alert('Payment failed: ' + err.message);
                }
            }).render('#paypal-button-container');
        </script>

        {{-- new3 --}}
        {{-- <script>
            paypal.Buttons({
                style: {
                    layout: 'vertical',
                    color: 'gold',
                    shape: 'rect',
                    label: 'paypal',
                    height: 40
                },
                createOrder: (data, actions) => {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '{{ Session::get('price') }}',
                                currency_code: 'USD'
                            }
                        }],
                        application_context: {
                            user_action: 'PAY_NOW',
                            shipping_preference: 'NO_SHIPPING',
                            landing_page: 'LOGIN' // Force login page
                        }
                    });
                },
                onApprove: (data, actions) => {
                    return actions.order.capture().then(function(orderData) {
                        window.location.href = 'http://127.0.0.1:8000/hotels/success';
                    });
                }
            }).render('#paypal-button-container');
        </script> --}}

        {{-- new --}}
        {{-- <script>
            paypal.Buttons({
                createOrder: (data, actions) => {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '{{ Session::get('price') }}',
                                currency_code: 'USD'
                            }
                        }]
                    });
                },
                onApprove: (data, actions) => {
                    return actions.order.capture().then(function(orderData) {
                        window.location.href = 'http://127.0.0.1:8000/hotels/success';
                    });
                }
            }).render('#paypal-button-container');
        </script> --}}


        {{-- new2 --}}
        {{-- <script>
            paypal.Buttons({
                style: {
                    shape: 'rect',
                    color: 'gold',
                    layout: 'vertical',
                    label: 'paypal'
                },
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '{{ Session::get('price') }}',
                                currency_code: 'USD'
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        alert('Transaction completed by ' + details.payer.name.given_name);
                        // Handle successful payment here
                    });
                },
                onError: function(err) {
                    console.error('PayPal Checkout Error:', err);
                    alert('An error occurred with PayPal checkout');
                }
            }).render('#paypal-button-container');
        </script> --}}

    </div>
@endsection
