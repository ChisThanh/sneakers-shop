<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('assets_home/img/fav.png') }}">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Site Title -->
    <title>Karma Shop</title>
    <!--
  CSS
  ============================================= -->
    <link rel="stylesheet" href="{{ asset('assets_home/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/ion.rangeSlider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets_home/css/ion.rangeSlider.skinFlat.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets_home/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/style.css') }}">

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    @stack('css')
</head>

<body>

    @include('home.layouts.header')

    @yield('content')

    <!-- start footer Area -->
    <footer class="footer-area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-3  col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h6>About Us</h6>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut labore dolore
                            magna aliqua.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4  col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h6>Newsletter</h6>
                        <p>Stay update with our latest</p>
                        <div class="" id="mc_embed_signup">

                            <form target="_blank" novalidate="true"
                                action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                                method="get" class="form-inline">

                                <div class="d-flex flex-row">

                                    <input class="form-control" name="EMAIL" placeholder="Enter Email"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '"
                                        required="" type="email">


                                    <button class="click-btn btn btn-default"><i class="fa fa-long-arrow-right"
                                            aria-hidden="true"></i></button>
                                    <div style="position: absolute; left: -5000px;">
                                        <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1"
                                            value="" type="text">
                                    </div>

                                    <!-- <div class="col-lg-4 col-md-4">
            <button class="bb-btn btn"><span class="lnr lnr-arrow-right"></span></button>
           </div>  -->
                                </div>
                                <div class="info"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3  col-md-6 col-sm-6">
                    <div class="single-footer-widget mail-chimp">
                        <h6 class="mb-20">Instragram Feed</h6>
                        <ul class="instafeed d-flex flex-wrap">
                            <li><img src="{{ asset('assets_home/img/i1.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('assets_home/img/i2.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('assets_home/img/i3.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('assets_home/img/i4.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('assets_home/img/i5.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('assets_home/img/i6.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('assets_home/img/i7.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('assets_home/img/i8.jpg') }}" alt=""></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h6>Follow Us</h6>
                        <p>Let us be social</p>
                        <div class="footer-social d-flex align-items-center">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-dribbble"></i></a>
                            <a href="#"><i class="fa fa-behance"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
                <p class="footer-text m-0">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | This template is made with <i class="fa fa-heart-o"
                        aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
            </div>
        </div>
    </footer>
    <!-- End footer Area -->

    <div class="card chat-app" id="chat-app" style="max-width: 364px;">
        <div class="card-header">
            Chat
            <span class="btn" id="btn-close-box">Đóng</span>
        </div>
        <div class="card-body">
            <ul class="chat-list">
                <li class="in">
                    <div class="chat-img">
                        <img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                    </div>
                    <div class="chat-body">
                        <div class="chat-message">
                            <h5>Admin</h5>
                            <p>Xin chào! Bạn có vấn đề gì cần hỗ trợ?</p>
                        </div>
                    </div>
                </li>
                @guest
                    <li>
                        <div class="chat-message" style="width: 100%;">
                            <p class="mt-2">Bạn cần đăng nhập để sử dụng tính năng này </p>
                            <center class="mt-2">
                                <a class="btn btn-primary" href="{{ route('login') }}">
                                    {{ __('homepage.login') }}
                                </a>
                            </center>
                        </div>
                    </li>
                @endguest


                {{-- <li class="out">
                    <div class="chat-img">
                        <img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar6.png">
                    </div>
                    <div class="chat-body">
                        <div class="chat-message">
                            <h5>User</h5>
                            <p>Xin chào</p>
                        </div>
                    </div>
                </li> --}}

            </ul>
        </div>
        <div class="card-footer text-muted">
            <form class="form-inline" id="form-chat">
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" class="form-control" id="message" placeholder="Enter message..">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Gửi</button>
            </form>
        </div>

    </div>

    <div class="box-icon" id="box-icon">
        <div class="icon"><img src="{{ asset('assets_home/img/chat.png') }}" alt="icon"></div>
    </div>
    <div id="modal-search-image" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tìm kiếm bằng hình ảnh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Chọn ảnh mà bạn muốn tìm kiếm</p>
                    <form action="#" id="form-upload-image" enctype="multipart/form-data">
                        <label class="btn btn-success" for="imggg">Tải hình ảnh</label>
                        <input type="file" name="image" id="imggg" class="d-none"
                            onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0]);
                            document.getElementById('blah').classList.remove('d-none');">
                        <img id="blah" src="#" alt="your image" width="260" height="280" />
                    </form>
                    <div id="data-search">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-form-upload">Tìm kiếm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('assets_home/js/vendor/jquery-2.2.4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="{{ asset('assets_home/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets_home/js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('assets_home/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets_home/js/jquery.sticky.js') }}"></script>
<script src="{{ asset('assets_home/js/nouislider.min.js') }}"></script>
{{-- <script src="{{ asset('assets_home/js/countdown.js') }}"></script> --}}
<script src="{{ asset('assets_home/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets_home/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets_home/js/main.js') }}"></script>
<script src="{{ asset('assets_home/js/helper.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>


@auth
    <script>
        var userId = '{{ Auth::id() }}';

        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: 'ap1'
        });
        const channel = pusher.subscribe(`user.${userId}`);
        //nhận tin nhắn mới
        channel.bind('chat', function(data) {
            console.log(data);
            var newLi = $(
                `<li class="in"><div class="chat-img"><img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar1.png"></div><div class="chat-body"><div class="chat-message"><h5 class="capitalize">Admin</h5><p>${data.message}</p></div></div></li>`
            );
            $('.chat-list').append(newLi);
        });
        // gửi tin nhắn đi
        $("#form-chat").submit(function(event) {
            event.preventDefault();

            console.log('dã gửi form');
            $.ajax({
                url: "/chat/broadcast/1",
                method: 'POST',
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    message: $("#form-chat #message").val(),
                }
            }).done(function(mgs) {
                var newLi = $(
                    `<li class="out"><div class="chat-img"><img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar6.png"></div><div class="chat-body"><div class="chat-message"><h5 class="capitalize">{{ auth()->user()->name }}</h5><p>${mgs}</p></div></div></li>`
                );

                $('.chat-list').append(newLi);
            });
        });
    </script>
@endauth
<script>
    $(document).ready(function() {
        var img = $("#blah");

        if (img.attr("src") === "#") {
            img.addClass("d-none");
        }

        var searchImg = $("#btn-search-image");
        $(searchImg).click(function(e) {
            e.preventDefault();
            $("#modal-search-image").modal('show');
        });
        var formUpload = $("#form-upload-image");
        $("#btn-form-upload").click(function(e) {
            e.preventDefault();
            var fileInput = $('#imggg')[0].files[0];
            if (!fileInput) {
                alert("Vui lòng chọn một ảnh tìm kiếm.");
                return;
            }
            const formData = new FormData(formUpload[0]);
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1:5000/api/search-image",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    $("#data-search").empty();

                    if (Array.isArray(response) && response.length === 0) {
                        $("#data-search").append(
                            "<p style='color:red;' >Không có sản phẩm</p>");
                    }

                    $.each(response, function(i, v) {
                        if (isFileNameValid(v.image)) {
                            v.image =
                                `{{ asset('assets_home/img/product') }}/${v.image}`;
                        }
                        $("#data-search").append(`<hr><div class="cart-search-img"><div><a href="/product/detail/${v.id}"><h4>${v.name}</h4></a><div>Giá: <span>${v.price}VND</span></div></div><div><img src="${v.image}" alt="img" width="75"></div>
                    </div>`);
                    });
                },
                error: function(response) {
                    console.log(response);
                }

            });
        });

        function isFileNameValid(fileName) {
            var regex = /^[^.]+\.[^.]+$/;
            return regex.test(fileName);
        }
    });
</script>

@stack('js')

</html>
