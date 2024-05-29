@extends('home.layouts.master')
@section('content')
<section class="order_details section_gap">
    <div class="container">
        <h3 class="title_confirmation">Thank you. Your order has been received.</h3>
        <div class="row order_d_inner">
            <div class="col-lg-4">
                <div class="details_item">
                    <h4>Order Info</h4>
                    <ul class="list">
                        <li><a href="#"><span>Order number</span> {{ $user->phone }}</a></li>
                        <li><a href="#"><span>Date</span> {{ $user->address }}</a></li>
                        <li><a href="#"><span>Total</span> {{ $order->total }}</a></li>
                        <li>
                            <a href="#">
                                <span>Payment status</span>
                                @if($order->payment_status == 0)
                                 <span><p style="color: red">Chưa thanh toán</p></span>
                                @else
                                <span><p style="color: rgb(3, 241, 122)">Đã thanh toán</p></span>
                                @endif
                            </a>
                        </li>

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
                        @foreach($cart1 as $item)
                        <tr>
                            <td>
                                <p>{{ $item['name'] }}</p>
                            </td>
                            <td>
                                <h5>{{ $item['quantity'] }}</h5>
                            </td>
                            <td>
                                <p>${{ $item['price'] }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Subtotal</h4>
                            </td>
                            <td></td>
                            <td>
                                <p>${{ $item['quantity'] * $item['price'] }}</p>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>
                                <h4>Shipping</h4>
                            </td>
                            <td></td>
                            <td>
                                <p>Flat rate: $50.00</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Total</h4>
                            </td>
                            <td></td>
                            <td>
                                <p>${{ $order->total }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a href="{{ route('my-order') }}" class="btn btn-primary">My Order</a>
        </div>
    </div>
</section>
@endsection
