@extends('home.layouts.master')

@section('content')
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>User</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">User</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <div class="row justify-content-center mt-1">
        <div class="col-md-8">
            <div class="card password-form">
                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group row col">
                                <label for="name" class="col-md-3 col-form-label text-md-right">Name:</label>
                                <div class="col-sm-9">
                                    <input id="name" type="text" class="form-control" name="name"
                                        value="{{ $user->name }}" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row col">
                                <label for="email" class="col-md-3 col-form-label text-md-right">Email:</label>
                                <div class="col-sm-9">
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ $user->email }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group row col">
                                <label for="firtsname" class="col-md-3 col-form-label text-md-right">First Name:</label>
                                <div class="col-sm-9">
                                    <input id="firtsname" type="text" class="form-control" name="firtsname"
                                        value="{{ $user->firtsname }}">
                                </div>
                            </div>

                            <div class="form-group row col">
                                <label for="lastname" class="col-md-3 col-form-label text-md-right">Last Name:</label>
                                <div class="col-sm-9">
                                    <input id="lastname" type="text" class="form-control" name="lastname"
                                        value="{{ $user->lastname }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group row col">
                                <label for="phone" class="col-md-3 col-form-label text-md-right">Phone:</label>
                                <div class="col-sm-9">
                                    <input id="phone" type="text" class="form-control" name="phone"
                                        value="{{ $user->phone }}">
                                </div>
                            </div>
                            <div class="form-group row col">
                                <label for="address" class="col-md-3 col-form-label text-md-right">Address:</label>
                                <div class="col-sm-9">
                                    <input id="address" class="form-control" name="address" value="{{ $user->address }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <center>
                                <button type="submit" class="btn btn-primary">Update Information</button>
                            </center>
                        </div>
                    </form>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="login_box_area mt-5">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <center>
                        <h1>Order</h1>
                    </center>
                    <table class="table">
                        <hr>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Total</th>
                                <th>Delivery Date</th>
                                <th>Payment</th>
                                <th>Order Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bills as $bill)
                                <tr>
                                    <td>{{ $bill->id }}</td>
                                    <td>{{ formatCurrency($bill->total) }}</td>
                                    <td>{{ $bill->delivery_date }}</td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $bill->payment_status }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $bill->status }}</span>
                                    </td>
                                    <td>
                                        @if ($bill->check_rating)
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('bill', ['order_id' => $bill->id]) }}">
                                                Đánh giá
                                            </a>
                                        @else
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('bill', ['order_id' => $bill->id]) }}">
                                                <i class="lnr lnr-eye"></i>
                                            </a>
                                        @endif
                                        <a class="btn btn-primary btn-sm"
                                            href="/bill/view-invoice-pdf/{{ $bill->id }}">PDF</a>
                                        <a class="btn btn-primary btn-sm"
                                            href="/bill/down-invoice-pdf/{{ $bill->id }}"><i
                                                class="lnr lnr-download"></i></a>

                                        @if ($bill->status === 'ORDER')
                                            <form action="{{ route('order.cancel', $bill->id) }}" method="POST"
                                                style="display:inline;" id="cancelOrderForm">
                                                @csrf
                                                <button id="btn-cancelOrderForm" type="submit"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="lnr lnr-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $("#btn-cancelOrderForm").click(function(e) {
                e.preventDefault();
                if (confirm('Bạn có muốn hủy đơn không?')) {
                    $('#cancelOrderForm').submit();
                }
            });
        });
    </script>
@endpush
