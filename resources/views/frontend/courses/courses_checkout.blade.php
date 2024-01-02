@extends('layouts.frontend.layer')
@section('title', 'Courses Payment | Drive Safe')
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-area" style="background-image:url('{{ url('assets/frontend/img/other/3.png') }}')">
        <div class="container">
            <div class="breadcrumb-inner">
                <div class="section-title mb-0">
                    <h2 class="page-title">Purchasing Summary</h2>
                    <ul class="page-list">
                        <li><a href="index.html">Home</a></li>
                        <li>Purchasing Summary</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">
        <div class="container">

            <div class="row">
                <div class="col-md-8 order-2 order-md-1">
                    @php $cart = Session::get('cart'); @endphp
                    <!-- Start Checkout -->
                    <h4 class="mb-3">Checkout </h4>

                    <hr class="separator-aqua">
                    <form action="{{ url('payment/stripe-card-payment') }}" method="post">
                        @csrf
                        <div id="upsell-checkbox">
                            @if (!blank($getAddonLists))
                                <div class="mb-3 py-3 bg-light">
                                    <div class="col mb-3">
                                        <div class="h5 mb-3">Certificate Delivery</div>
                                        <div class="product-description h6 mb-2">Provide your completion certificate to the
                                            court to
                                            dismiss your ticket. Or submit to your insurance company to get an insurance
                                            discount.
                                        </div>
                                    </div>
                                    @foreach ($getAddonLists as $certificate)
                                        @if ($certificate->is_type == '2')
                                            <div class="checkbox-wrapper form-check upsell-checkbox__checkbox-wrapper">
                                                <input id="option_{{ $certificate->id }}" type="checkbox"
                                                    name="option_{{ $certificate->id }}"
                                                    class="form-check-input checkbox-box upsell-checkbox__checkbox"
                                                    onchange="cart({{ $certificate->id }})"
                                                    {{ isset($cart[$certificate->id]) ? 'checked' : '' }}>
                                                <label for="option_{{ $certificate->id }}"
                                                    class="form-check-label d-block cursor-pointer upsell-checkbox__label">
                                                    <div class="font-weight-semibold upsell-checkbox__upsell">
                                                        <p><b>{!! $certificate->name !!} only ${{ $certificate->amount }}</b>
                                                        </p>
                                                    </div>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            @if (!blank($getAddonLists))
                                <div class="mb-3 py-3 bg-light">
                                    <div class="col mb-3">
                                        <div class="h5 mb-3">Add-Ons</div>
                                    </div>
                                    @foreach ($getAddonLists as $certificate)
                                        @if ($certificate->is_type == '1')
                                            <div class="checkbox-wrapper form-check upsell-checkbox__checkbox-wrapper">
                                                <input id="option_{{ $certificate->id }}"
                                                    name="option_{{ $certificate->id }}" type="checkbox"
                                                    class="form-check-input checkbox-box upsell-checkbox__checkbox"
                                                    onchange="cart({{ $certificate->id }})"
                                                    {{ isset($cart[$certificate->id]) ? 'checked' : '' }}>
                                                <label for="option_{{ $certificate->id }}"
                                                    class="form-check-label d-block cursor-pointer upsell-checkbox__label">
                                                    <div class="font-weight-semibold upsell-checkbox__upsell">
                                                        <p><b>{!! $certificate->name !!} only ${{ $certificate->amount }}</b>
                                                        </p>
                                                    </div>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            <hr>
                            <button class="btn btn-base btn-11 mb-4 mx-auto" id="checkout_Btn" type="submit"
                                style="margin-bottom: 80px !important; width: 320px;">Start Your Journey!</button>
                        </div>
                    </form>
                    <!-- End Checkout -->
                </div>
                <div class="col-md-4 mb-4 order-1 order-md-2 ">
                    <h4 style="margin-bottom: 16px;">Summary</h4>
                    <hr class="separator-aqua">

                    <span style="color: #404652; font-size:30px; position: relative;">
                        Shopping Cart
                    </span>
                    <ul class="list-group mb-3" id="cart">
                        @php $price = $getCourse['price']; @endphp
                        <li class="list-group-item d-flex justify-content-between lh-condensed mt-3">
                            <h5>1. {{ $getCourse['title'] }}</h5>
                            <h5 class="text-muted" style="display:inline-block; text-align:right;">
                                ${{ $getCourse['price'] }} </h5>
                        </li>
                        @if (!blank($cart))
                            @php $count = 2; @endphp
                            @foreach ($cart as $val)
                                @php $price +=$val['price']; @endphp
                                <li class="list-group-item d-flex justify-content-between lh-condensed mt-3">
                                    <h5>{{ $count }}. {{ $val['name'] }}</h5>
                                    <h5 class="text-muted" style="display:inline-block; text-align:right;">
                                        ${{ $val['price'] }} </h5>
                                </li>
                                @php $count++; @endphp
                            @endforeach
                        @endif
                        <li class="list-group-item d-flex justify-content-between" id="cartItem">
                            <div style="font-size:24px;">Total</div>
                            <div id="totalPrice" style="font-size:24px;">
                                <strong>${{ $price }} </strong>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <!-- course area end -->
    <script>
        function cart(val) {
            let option = document.getElementById('option_' + val).checked;
            console.log(val, ' | ', option);
            $.ajax({
                type: 'POST',
                url: '{{ url('payment/cart') }}',
                data: {
                    "val": val,
                    "option": option == true ? 1 : 0,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    $('#cart').html(response);
                }
            });
        }
    </script>
    <style>
        body label.upsell-checkbox__label {
            line-height: 23px;
        }

        body .checkbox-wrapper {
            padding-left: 40px;
        }
    </style>
@endsection
