@extends('home.layouts.master')
@section('content')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shop Category page</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Shop<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Fashon Category</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
    <div class="container">
        <div class="row">
            <div class="col-12 text-right my-3">
                <span><i class="fa-solid fa-filter d-inline"></i> Sắp xếp:</span>
                <a href="{{ route('product.index', ['sort' => 'default']) }}" class="btn btn-outline-dark mx-1"><i
                        class="fa-solid fa-not-equal"></i> Default</a>
                <a href="{{ route('product.index', ['sort' => 'az']) }}" class="btn btn-outline-dark mx-1"><i
                        class="fa-solid fa-arrow-up-a-z"></i> A-Z</a>
                <a href="{{ route('product.index', ['sort' => 'za']) }}" class="btn btn-outline-dark mx-1"><i
                        class="fa-solid fa-arrow-down-a-z"></i> Z-A</a>
                <a href="{{ route('product.index', ['sort' => 'asc']) }}" class="btn btn-outline-dark mx-1"><i
                        class="fa-solid fa-arrow-up-1-9"></i> Price asc</a>
                <a href="{{ route('product.index', ['sort' => 'desc']) }}" class="btn btn-outline-dark mx-1"><i
                        class="fa-solid fa-arrow-down-1-9"></i> Price desc</a>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5">
                <div class="sidebar-categories">
                    <div class="head">Category Sneaker</div>
                    <ul class="main-categories">
                        <li class="main-nav-list">
                            @foreach ($category as $item)
                                <a href="/product?category_id={{ $item->id }}"><span
                                        class="lnr lnr-arrow-right"></span>{{ $item->name }}</a>
                            @endforeach
                        </li>
                    </ul>
                </div>
                <div class="sidebar-categories">
                    <div class="head">Brands</div>
                    <ul class="main-categories">
                        <li class="main-nav-list">
                            @foreach ($brand as $item)
                                <a href="/product/?brand_id={{ $item->id }}"><span
                                        class="lnr lnr-arrow-right"></span>{{ $item->name }}</a>
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-7">
                <!-- Start Filter Bar -->
                <div class="filter-bar d-flex flex-wrap align-items-center">
                    <div class="pagination">
                        @if (!$product->onFirstPage())
                            <a href="{{ $product->appends(request()->input())->previousPageUrl() }}" class="prev-arrow">
                                <i class="lnr lnr-arrow-left" aria-hidden="true"></i>
                            </a>
                        @endif

                        @for ($i = 1; $i <= $product->lastPage(); $i++)
                            <a href="{{ $product->appends(request()->input())->url($i) }}"
                                class="{{ $product->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                        @endfor

                        @if ($product->hasMorePages())
                            <a href="{{ $product->appends(request()->input())->nextPageUrl() }}" class="next-arrow"><i
                                    class="lnr lnr-arrow-right" aria-hidden="true"></i></a>
                        @endif
                    </div>
                </div>
                <!-- End Filter Bar -->
                <!-- Start Best Seller -->
                <section class="lattest-product-area pb-40 category-list">
                    <div class="row">
                        @foreach ($product as $item)
                            <!-- single product -->
                            <div class="col-lg-4 col-md-6">
                                <div class="single-product">
                                    <a href="{{ route('product.detailpro', $item->id) }}">
                                        <img style="height: 271px;" class="img-fluid" src="{{ $item->image }}"
                                            alt="">
                                    </a>
                                    <div class="product-details">
                                        <h6>{{ $item->name }}</h6>
                                        <div class="price">
                                            <h6>{{ formatCurrency($item->price_sale) }} </h6>
                                            <h6 class="l-through">{{ formatCurrency($item->price) }}
                                            </h6>
                                        </div>
                                        <div class="prd-bottom">
                                            <a href="#" class="social-info add-to-cart-all"
                                                data-id="{{ $item->id }}">
                                                <span class="ti-bag"></span>
                                                <p class="hover-text">add to bag</p>
                                            </a>
                                            <a href="" class="social-info">
                                                <span class="lnr lnr-heart"></span>
                                                <p class="hover-text">Wishlist</p>
                                            </a>
                                            <a href="" class="social-info">
                                                <span class="lnr lnr-sync"></span>
                                                <p class="hover-text">compare</p>
                                            </a>
                                            <a href="{{ route('product.detailpro', ['id' => $item->id]) }}"
                                                class="social-info">
                                                <span class="lnr lnr-move"></span>
                                                <p class="hover-text">view more</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
                <!-- End Best Seller -->
            </div>
        </div>
    </div>

    <!-- Start related-product Area -->
    <section class="related-product-area section_gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Deals of the Week</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore
                            magna aliqua.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                            <div class="single-related-product d-flex">
                                <a href="#"><img src="{{ asset('assets_home/img/r1.jpg') }}" alt=""></a>
                                <div class="desc">
                                    <a href="#" class="title">Black lace Heels</a>
                                    <div class="price">
                                        <h6>$189.00</h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                            <div class="single-related-product d-flex">
                                <a href="#"><img src="{{ asset('assets_home/img/r2.jpg') }}" alt=""></a>
                                <div class="desc">
                                    <a href="#" class="title">Black lace Heels</a>
                                    <div class="price">
                                        <h6>$189.00</h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                            <div class="single-related-product d-flex">
                                <a href="#"><img src="{{ asset('assets_home/img/r3.jpg') }}" alt=""></a>
                                <div class="desc">
                                    <a href="#" class="title">Black lace Heels</a>
                                    <div class="price">
                                        <h6>$189.00</h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                            <div class="single-related-product d-flex">
                                <a href="#"><img src="{{ asset('assets_home/img/r5.jpg') }}" alt=""></a>
                                <div class="desc">
                                    <a href="#" class="title">Black lace Heels</a>
                                    <div class="price">
                                        <h6>$189.00</h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                            <div class="single-related-product d-flex">
                                <a href="#"><img src="{{ asset('assets_home/img/r6.jpg') }}" alt=""></a>
                                <div class="desc">
                                    <a href="#" class="title">Black lace Heels</a>
                                    <div class="price">
                                        <h6>$189.00</h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                            <div class="single-related-product d-flex">
                                <a href="#"><img src="{{ asset('assets_home/img/r7.jpg') }}" alt=""></a>
                                <div class="desc">
                                    <a href="#" class="title">Black lace Heels</a>
                                    <div class="price">
                                        <h6>$189.00</h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="single-related-product d-flex">
                                <a href="#"><img src="{{ asset('assets_home/img/r9.jpg') }}" alt=""></a>
                                <div class="desc">
                                    <a href="#" class="title">Black lace Heels</a>
                                    <div class="price">
                                        <h6>$189.00</h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="single-related-product d-flex">
                                <a href="#"><img src="{{ asset('assets_home/img/r10.jpg') }}" alt=""></a>
                                <div class="desc">
                                    <a href="#" class="title">Black lace Heels</a>
                                    <div class="price">
                                        <h6>$189.00</h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="single-related-product d-flex">
                                <a href="#"><img src="{{ asset('assets_home/img/r11.jpg') }}" alt=""></a>
                                <div class="desc">
                                    <a href="#" class="title">Black lace Heels</a>
                                    <div class="price">
                                        <h6>$189.00</h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ctg-right">
                        <a href="#" target="_blank">
                            <img class="img-fluid d-block mx-auto" src="{{ asset('assets_home/img/category/c5') }}.jpg"
                                alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End related-product Area -->
@endsection
