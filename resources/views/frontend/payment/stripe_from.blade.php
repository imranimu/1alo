@extends('layouts.frontend.layer')
@section('title', 'Stripe Payment | Drive Safe')
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-area" style="background-image:url('{{ asset('assets/frontend/img/other/1.png') }}')">
        <div class="container">
            <div class="breadcrumb-inner">
                <div class="section-title mb-0">
                    <h2 class="page-title">STRIPE</h2>
                    <ul class="page-list">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>STRIPE PAYMENT</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- team area start -->
    <div class="team-area pd-top-120 pd-bottom-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="coming-cont">
                        <header>
                            <p>REDIRECTING TO STRIPE PAYMENT GATEWAY.</p>
                            <p>PLEASE WAIT .......</p>
                            <img src="{{ asset('assets/frontend/images/loading_big.gif') }}" height="80" width="80">
                        </header>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- team area end -->
    <!-- Stripe JavaScript library -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Set Stripe publishable key to initialize Stripe.js
        const stripe = Stripe('pk_test_qAdlkxXSpI4zKrXknf9HgVek');

        // Payment request handler
        $(document).ready(function() {
            createCheckoutSession().then(function(data) {
                console.log(data);
                if (data.sessionId && data.status == '1') {
                    stripe.redirectToCheckout({
                        sessionId: data.sessionId,
                    }).then(handleResult);
                } else {
                    //handleResult(data);
                    //window.location.href = '{{ url('/payment-failed/') }}'+data.transaction_id;
                }
            });
        });

        // Create a Checkout Session with the selected product
        const createCheckoutSession = function(stripe) {
            return fetch('{{ url('payment/payment-init') }}', {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    createCheckoutSession: 1,
                    stripe_order_id: {{ $stripe_order_id }},
                }),
            }).then(function(result) {
                return result.json();
            });
        };
    </script>
	
	<style>
		.coming-cont {
			text-align: center;
		}
		
		header p {
			font-size: 24px;
			font-weight: bold;
		}
	</style>
@endsection
