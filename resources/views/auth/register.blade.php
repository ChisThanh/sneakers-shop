@extends('home.layouts.master')
@section('content')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>{{ __('homepage.register') }}</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">{{ __('homepage.home') }}<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">{{ __('homepage.register') }}</a>
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
                            <a class="primary-btn" href="{{ route('login') }}">{{ __('homepage.login') }} </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>{{ __('homepage.register') }} to enter</h3>
                        <form class="row login_form" action="{{ route('register') }}" method="post" id="contactForm"
                            novalidate="novalidate">
                            @csrf
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="name"
                                    placeholder="{{ __('homepage.username') }}">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="email" placeholder="Email">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" name="password"
                                    placeholder="{{ __('homepage.password') }}">
                            </div>

                            <div class="col-md-12 form-group mt-5">
                                <button type="submit" value="submit" class="primary-btn">{{ __('homepage.register') }}
                                </button>
                                <a href="#">{{ __('homepage.ForgotPassword') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->
@endsection

@push('js')
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
