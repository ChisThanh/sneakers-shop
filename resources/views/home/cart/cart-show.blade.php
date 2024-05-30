@extends('home.layouts.master')
@section('content')
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Cart</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Cart</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <div class="login_box_area">
        <div class="container">
            <div class="container">
                <div class="cart_inner">
                    <div class="table-responsive">
                        @if ($cart->totalQuantity == 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-danger">Giỏ hàng rỗng. Vui lòng chọn sản phẩm -> <a
                                                class="btn btn-primary" href="{{ route('product.index') }}">Click Here</a>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart->items as $item)
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <div class="d-flex">
                                                        <img src="{{ asset('assets_home') . $item['image'] }}"
                                                            alt="" width="150px" height="150px" class="mx-auto">
                                                    </div>
                                                    <div class="media-body">
                                                        <p>{{ $item['name'] }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="price">{{ $item['price'] }}</h5>
                                            </td>
                                            <td>
                                                <div class="product_count">
                                                    <div class="product_count">
                                                        <input type="number" name="quantity" min="1"
                                                            value="{{ $item['quantity'] }}" title="Quantity:"
                                                            class="input-text qty inp-qty" data-id="{{ $item['id'] }}">
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <h5 class="total">{{ $item['quantity'] * $item['price'] }}</h5>
                                            </td>
                                            <td>
                                                <h5> <a onclick="return confirm('Bạn có muốn xóa?')"
                                                        href="{{ route('cart.delete', $item['id']) }}"
                                                        class=" text-danger">Delete</a></h5>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="bottom_button">
                                        <td><a onclick="return confirm('Bạn có muốn xóa tất cả?')"
                                                href="{{ route('cart.clear') }}" class="btn btn-danger">Delete All</a></td>
                                        <td></td>
                                        <td>
                                            ToTal: {{ $cart->totalQuantity }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <h5>Subtotal</h5>
                                        </td>
                                        <td>
                                            <h5>{{ $cart->totalPrice }}</h5>
                                        </td>
                                    </tr>
                                    <tr class="out_button_area">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="checkout_btn_inner d-flex align-items-center">
                                                <a class="gray_btn" href="{{ route('product.index') }}">Continue
                                                    Shopping</a>
                                                <a class="primary-btn" href="{{ route('checkout') }}">Proceed to
                                                    checkout</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')
    <script>
        $(document).ready(function() {

            $(".input-text.qty").change(function(e) {
                var $parent = $(this).closest('tr');
                var price = $parent.find('.price').text();

                var productId = $(this).data('id');
                var qty = $(this).val();

                update(productId, qty, price, $parent.find('.total'));

            });

            function update(id, qty, price, el_total) {
                $.ajax({
                    type: "POST",
                    url: "/cart/updateItem/" + id,
                    data: {
                        quantity: qty,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: "json",
                    success: function(response) {
                        el_total.text(`${(qty * price).toFixed(2)}`);
                    },
                    error: function(xhr, status, error) {
                        alert("Cập nhật giỏ hàng không thành công");
                    }

                });
            }
        });
    </script>
@endpush
