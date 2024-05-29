@extends('home.layouts.master')
@section('content')
    <!--================Checkout Area =================-->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Checkout</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Checkout</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>Billing Details</h3>
                        <form class="row contact_form" action="{{ route('checkout.update') }}" method="post"
                            id="form-checkout">
                            @csrf
                            <div class="col-md-6 form-group p_star">
                                <label for="FirstName">FirstName</label>
                                <input type="text" class="form-control" id="first" value="{{ $user->firtsname }}"
                                    name="firtsname" required>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label for="LastName">LastName</label>
                                <input type="text" class="form-control" id="last" value="{{ $user->lastname }}"
                                    name="lastname" required>
                            </div>

                            <div class="col-md-6 form-group p_star">
                                <label for="Phone">Phone</label>
                                <input type="text" class="form-control" id="number" value="{{ $user->phone }}"
                                    name="phone" required>
                            </div>

                            <div class="col-md-6 form-group p_star">
                                <label for="address">address</label>
                                <input type="text" class="form-control" id="address" value="{{ $user->address }}"
                                    name="address" required>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="order_box">
                            <h2>Your Order</h2>
                            <ul class="list">
                                <li><a href="#">Product <span>Total</span></a></li>
                                @foreach ($cart->items as $item)
                                    <li><a href="#">{{ $item['name'] }} <span class="middle">x
                                                {{ $item['quantity'] }}</span> <span
                                                class="last">{{ $item['quantity'] * $item['price'] }}</span></a></li>
                                @endforeach
                            </ul>
                            <ul class="list list_2">
                                <li><a href="#">Subtotal <span>{{ $cart->totalPrice }}</span></a></li>
                                <li><a href="#">Shipping <span>Flat rate: $50.00</span></a></li>
                                <li><a href="#">Total <span>{{ $cart->totalPrice + 50 }}</span></a></li>
                            </ul>
                            <div class="payment_item">
                                <div class="radion_btn">
                                    <input type="radio" id="f-option5" name="selector">
                                    <label for="f-option5">Check payments</label>
                                    <div class="check"></div>
                                </div>
                            </div>
                            <div class="payment_item active">
                                <div class="radion_btn">
                                    <input type="radio" id="f-option6" name="selector">
                                    <label for="f-option6">Paypal </label>
                                    <img src="img/product/card.jpg" alt="">
                                    <div class="check"></div>
                                </div>
                            </div>
                            <button type="submit" name="submit" id="btn-submit" class="btn primary-btn"
                                onclick="document.querySelector('#form-checkout').submit()">Proceed to
                                Paypal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
