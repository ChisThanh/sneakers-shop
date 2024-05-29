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
            <div class="col-12 text-right mt-3">
                <span><i class="fa-solid fa-filter d-inline"></i> Sắp xếp:</span>
                <a href="{{ route('cate', ['id' => $id, 'sort' => 'default']) }}" class="btn btn-outline-dark mx-1"><i class="fa-solid fa-not-equal"></i> Default</a>
                <a href="{{ route('cate', ['id' => $id, 'sort' => 'az']) }}" class="btn btn-outline-dark mx-1"><i class="fa-solid fa-arrow-up-a-z"></i> A-Z</a>
                <a href="{{ route('cate', ['id' => $id, 'sort' => 'za']) }}" class="btn btn-outline-dark mx-1"><i class="fa-solid fa-arrow-down-a-z"></i> Z-A</a>
                <a href="{{ route('cate', ['id' => $id, 'sort' => 'asc']) }}" class="btn btn-outline-dark mx-1"><i class="fa-solid fa-arrow-up-1-9"></i> Price asc</a>
                <a href="{{ route('cate', ['id' => $id, 'sort' => 'desc']) }}" class="btn btn-outline-dark mx-1"><i class="fa-solid fa-arrow-down-1-9"></i> Price desc</a>
            </div>



            <div class="col-xl-3 col-lg-4 col-md-5">
                <div class="sidebar-categories">
                    @include("home.products.ShowCate")
                </div>
                <div class="sidebar-categories">
                    @include("home.products.ShowBrand")
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-7">
                <!-- Start Filter Bar -->
                <div class="filter-bar d-flex flex-wrap align-items-center">


                    <div class="pagination">
                        @if ($product->onFirstPage())
                        <span class="prev-arrow disabled"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></span>
                        @else
                        <a href="{{ $product->appends(request()->input())->previousPageUrl() }}" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                        @endif

                        @for ($i = 1; $i <= $product->lastPage(); $i++)
                         <a href="{{ $product->appends(request()->input())->url($i) }}" class="{{ $product->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                        @endfor

                        @if ($product->hasMorePages())
                         <a href="{{ $product->appends(request()->input())->nextPageUrl() }}" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        @else
                        <span class="next-arrow disabled"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
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
                                <img class="img-fluid" src="{{ $item->image }}.jpg"
                                    alt="">
                                <div class="product-details">
                                    <h6>{{ $item->name }}</h6>
                                    <div class="price">
                                        <h6>{{ $item->price_sale }}</h6>
                                        <h6 class="l-through">{{ $item->price }}</h6>
                                    </div>
                                    <div class="prd-bottom">

                                        <a href="{{ route('cart.add',$item['id']) }}" class="social-info">
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
                                        <a href="" class="social-info">
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
                <!-- Start Filter Bar -->
                <div class="filter-bar d-flex flex-wrap align-items-center">

                    <div class="pagination">
                        @if ($product->onFirstPage())
                        <span class="prev-arrow disabled"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></span>
                        @else
                        <a href="{{ $product->appends(request()->input())->previousPageUrl() }}" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                        @endif

                        @for ($i = 1; $i <= $product->lastPage(); $i++)
                         <a href="{{ $product->appends(request()->input())->url($i) }}" class="{{ $product->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                        @endfor

                        @if ($product->hasMorePages())
                         <a href="{{ $product->appends(request()->input())->nextPageUrl() }}" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        @else
                        <span class="next-arrow disabled"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                        @endif

                    </div>
                </div>
                <!-- End Filter Bar -->
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
