@extends('home.layouts.master')
@section('content')
    <!--================Single Product Area =================-->
    <div class="product_image_area my-3">
        <div class="container">
            <div class="row s_product_inner">
                <div class="col-lg-6">
                    <div class="s_Product_carousel">
                        <div class="single-prd-item">
                            <img class="img-fluid" src="{{ $product->image }}" alt="">
                        </div>
                        <div class="single-prd-item">
                            <img class="img-fluid" src="{{ $product->image }}" alt="">
                        </div>
                        <div class="single-prd-item">
                            <img class="img-fluid" src="{{ $product->image }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">
                        <h3>{{ $product->name }}</h3>
                        <h2>{{ formatCurrency($product->price_sale) }}</h2>
                        <ul class="list">
                            <li><a class="active" href="#"><span>Category</span> {{ $product->category->name }}</a>
                            </li>
                            <li><span>Availibility</span> : In Stock</li>
                        </ul>
                        <div class="my-2">
                            {{ $product->description }}
                        </div>

                        <div class="product_count">
                            <label for="qty">Quantity:</label>
                            <input type="number" name="quantity" min="1" value="1" title="Quantity:"
                                class="input-text qty" id="qty">
                        </div>
                        <div class="card_area d-flex align-items-center">
                            <button type="submit" class="btn primary-btn add-to-cart-detail"
                                data-id="{{ $product->id }}">Add to Cart</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                        aria-selected="true">Description</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false">Specification</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab"
                        aria-controls="review" aria-selected="false">Reviews</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                    {{ $product->description }}
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <h5>Width</h5>
                                    </td>
                                    <td>
                                        <h5>128mm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Height</h5>
                                    </td>
                                    <td>
                                        <h5>508mm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Depth</h5>
                                    </td>
                                    <td>
                                        <h5>85mm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Weight</h5>
                                    </td>
                                    <td>
                                        <h5>52gm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Quality checking</h5>
                                    </td>
                                    <td>
                                        <h5>yes</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Freshness Duration</h5>
                                    </td>
                                    <td>
                                        <h5>03days</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>When packeting</h5>
                                    </td>
                                    <td>
                                        <h5>Without touch of hand</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Each Box contains</h5>
                                    </td>
                                    <td>
                                        <h5>60pcs</h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row total_rate">
                                <div class="col-6">
                                    <div class="box_total">
                                        <h5>Overall</h5>
                                        <h4>{{ $ratingAvg }}</h4>
                                        <h6>{{ $numberOfReviews }}</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="rating_list">
                                        <h3>Based on {{ $numberOfReviews }} Reviews</h3>
                                        <ul class="list">
                                            <div id="rateYo"></div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="review_list">
                                @foreach ($productReviews as $each)
                                    <hr>
                                    <div class="review_item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4>{{ $each->user->name }}</h4>
                                                <div id="rateYo2_{{ $each->user->id }}"></div>
                                            </div>
                                        </div>
                                        <p>{{ $each->comment }} <br> {{ $each->created_at->format('d/m/Y') }}</p>
                                        <hr>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-6">
                            @if (auth()->check())
                                @if (checkCmt($product->id))
                                    <div class="review_box">
                                        <h4>Add a Review</h4>
                                        <p>Your Rating:</p>
                                        <form class="row contact_form" action="{{ route('post.commnet', $product->id) }}"
                                            method="post" id="contactForm" novalidate="novalidate">
                                            @csrf
                                            <ul class="list">
                                                <div id="rateYo1"></div>
                                                <div class="form-group">
                                                    <input type="hidden" name="rating" id="rating_input">
                                                </div>
                                            </ul>
                                            <p>Outstanding</p>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="comment" id="message" rows="1" placeholder="Review"
                                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Review'"></textarea></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <button type="submit" value="submit" class="primary-btn">Submit
                                                    Now</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-danger">
                                    <strong>Please Login!</strong> Click here -> <a href="{{ route('login') }}">Login</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


    <script>
        $(document).ready(function() {
            $(".add-to-cart-detail").click(function(e) {
                e.preventDefault();
                let idP = $(this).attr("data-id");
                let qty = $("#qty").val();
                $.ajax({
                    type: "GET",
                    url: "/cart/add/" + idP,
                    data: {
                        'quantity': qty
                    },
                    dataType: "json",
                    success: function(response) {
                        $.toast({
                            heading: 'Success',
                            text: 'Thêm vào giỏ hàng thành công',
                            showHideTransition: 'fade',
                            icon: 'success',
                            position: 'top-center',
                        })
                        updateQuantityCart();
                    },
                    error: function(response) {
                        alert("Thêm vào giỏ hàng không thành công");
                    }
                });
            });
        });

        $(function() {
            let ratingAvg = '{{ $ratingAvg ?? 0 }}';
            let rating_users = @json($rating_user);

            if (ratingAvg) {
                $("#rateYo").rateYo({
                    rating: ratingAvg,
                    starWidth: "30px"
                });
            }

            @foreach ($rating_user as $user_id => $rating)
                $("#rateYo2_{{ $user_id }}").rateYo({
                    rating: {{ $rating }},
                    starWidth: "10px"
                });
            @endforeach

            $("#rateYo1").rateYo({
                rating: 0,
                starWidth: "30px",
                onSet: function(rating, rateYoInstance) {
                    $('#rating_input').val(rating);
                }
            });
        });
    </script>
@endsection
