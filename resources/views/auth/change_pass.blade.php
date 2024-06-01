@extends('home.layouts.master')
@section('content')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>{{ __('homepage.home') }}</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">{{ __('homepage.home') }}<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Change password</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Login Box Area =================-->
    <section class="login_box_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="{{ asset('assets_home/img/login.jpg') }}" alt="">
                        <div class="hover">
                            <h4>New to our website?</h4>
                            <p>There are advances being made in science and technology everyday, and a good example of this
                                is the</p>
                            <a class="primary-btn" href="{{ route('register') }}">Create an Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Change password</h3>
                        <form class="row login_form" action="{{ route('password.update') }}" method="post"
                            novalidate="novalidate">
                            @csrf
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="email" placeholder="Email">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" name="password"
                                    placeholder="{{ __('homepage.password') }}">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" name="password_new"
                                    placeholder="{{ __('homepage.password') }} mới">
                            </div>
                            <div class="col-md-12 form-group mt-4">
                                <button type="submit" value="submit" class="primary-btn">Change
                                </button>
                            </div>
                            @if (session('error'))
                                <div class="col-md-12 form-group mt-1">
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets_home/css/jquery.toast.css') }}">
@endpush
@push('js')
    <script src="{{ asset('assets_home/js/jquery.toast.js') }}"></script>
    @if ($errors->any())
        <script>
            $.toast({
                heading: 'Error',
                @foreach ($errors->all() as $error)
                    text: '{{ $error }}',
                @endforeach
                showHideTransition: 'fade',
                icon: 'error'
            })
        </script>
    @endif
@endpush
