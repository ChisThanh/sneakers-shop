@extends('home.layouts.master')
@section('content')
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
    <section class="order_details section_gap">
        <div class="container">
            <h3 class="title_confirmation">Thank you. Your order has been received.</h3>
            <div class="row order_d_inner">
                <div class="col-lg-4">
                    <div class="details_item">
                        <h4>Order Info</h4>
                        <ul class="list">
                            <li><a href="#"><span>Order number</span> {{ $user->phone }}</a></li>
                            <li><a href="#"><span>Address</span> {{ $user->address }}</a></li>
                            <li><a href="#"><span>Total</span> {{ formatCurrency($order->total) }}</a></li>
                            <li>
                                <a href="#">
                                    <span>Payment status</span>
                                    @if ($order->payment_status == 0)
                                        <span>
                                            <p style="color: red">Chưa thanh toán</p>
                                        </span>
                                    @else
                                        <span>
                                            <p style="color: rgb(3, 241, 122)">Đã thanh toán</p>
                                        </span>
                                    @endif
                                </a>
                            </li>
                            @if (!checkPayment($order->id))
                                <li>
                                    <form action="{{ route('vnpayment') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="redirect">
                                        <input type="hidden" name="id_order" value="{{ $order->id }}">
                                        <input type="hidden" name="total_order" value="{{ $order->total }}">
                                        <button class="btn btn-primary">Thanh toán bằng VNPAY</button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="order_details_table">
                <h2>Order Details</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->details as $item)
                                <tr>
                                    <td>
                                        <p>{{ $item['product_name'] }}</p>
                                    </td>
                                    <td>
                                        <h5>{{ $item['quantity'] }}</h5>
                                    </td>
                                    <td>
                                        <p>{{ formatCurrency($item['price']) }}</p>
                                    </td>
                                    @if (checkCmt($item['product_id']))
                                        <td>
                                            <a href="/product/detail/{{ $item['product_id'] }}" class="btn btn-success">Đánh
                                                giá</a>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Subtotal</h4>
                                    </td>
                                    <td></td>
                                    <td>
                                        <p>{{ formatCurrency($item['quantity'] * $item['price']) }}</p>
                                    </td>

                                </tr>
                            @endforeach
                            <tr>
                                <td>
                                    <h4>Shipping</h4>
                                </td>
                                <td></td>
                                <td>
                                    <p>Flat rate: {{ formatCurrency(20000) }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>Total</h4>
                                </td>
                                <td></td>
                                <td>
                                    <p>{{ formatCurrency($order->total) }}</p>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('show-user') }}" class="btn btn-primary">My Order</a>
            </div>
        </div>
    </section>
@endsection
