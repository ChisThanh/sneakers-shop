@extends('admin.layouts.master')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item active">Chat</li>
                    </ol>
                </div>
                <h4 class="page-title">Chat</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <!-- start chat users-->
        <div class="col-xl-3 col-lg-6 order-lg-1 order-xl-1">
            <div class="card">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="#allUsers" data-toggle="tab" aria-expanded="false" class="nav-link active py-2">
                                User
                            </a>
                        </li>
                    </ul> <!-- end nav-->
                    <div class="tab-content">
                        <div class="tab-pane show active p-3" id="newpost">

                            <!-- start search box -->
                            <div class="app-search">
                                <form>
                                    <div class="form-group position-relative">
                                        <input type="text" class="form-control" placeholder="User name..." />
                                        <span class="mdi mdi-magnify search-icon"></span>
                                    </div>
                                </form>
                            </div>
                            <!-- end search box -->

                            <!-- users -->
                            <div class="row">
                                <div class="col">
                                    <div data-simplebar style="max-height: 550px">
                                        <a href="javascript:void(0);" class="text-body">
                                            <div class="media bg-light mt-1 p-2">
                                                <img src="{{ asset('assets_admin/images/users/avatar-2.jpg') }}"
                                                    class="mr-2 rounded-circle" height="48" alt="Brandon Smith" />
                                                <div class="media-body ">
                                                    <h5 class="mt-0 mb-0 font-14">
                                                        <span class="float-right text-muted font-12">4:30am</span>
                                                        Brandon Smith
                                                    </h5>
                                                    <p class="mt-1 mb-0 text-muted font-14">
                                                        <span class="w-25 float-right text-right">
                                                            <span class="badge badge-danger-lighten">3
                                                            </span>
                                                        </span>
                                                        <span class="w-75">How are you today?</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div> <!-- end slimscroll-->
                                    @foreach ($users as $user)
                                        <div data-simplebar style="max-height: 550px">
                                            <a href="javascript:void(0);" class="text-body user-chat"
                                                data-id="{{ $user->id }}">
                                                <div class="media mt-1 p-2 align-items-center">
                                                    <img src="{{ asset('assets_admin/images/users/avatar-2.jpg') }}"
                                                        class="mr-2 rounded-circle" height="48"
                                                        alt="{{ ucfirst($user->name) }}" />
                                                    <div class="media-body">
                                                        <h5 class="mt-0 mb-0 font-14">
                                                            {{-- <span class="float-right text-muted font-12">4:30am</span> --}}
                                                            <span class="w-25 float-right text-right">
                                                                <span class="badge badge-danger-lighten notifi-user"
                                                                    data-id="{{ $user->id }}">
                                                                    0
                                                                </span>
                                                            </span>
                                                            {{ ucfirst($user->name) }}
                                                        </h5>
                                                        <span class="w-75 mgs"></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div> <!-- end slimscroll-->
                                    @endforeach

                                </div> <!-- End col -->
                            </div>
                            <!-- end users -->
                        </div> <!-- end Tab Pane-->
                    </div> <!-- end tab content-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <!-- end chat users-->

        <!-- chat area -->
        <div class="col-xl-9 col-lg-12 order-lg-2 order-xl-1">
            <div class="card">
                <div class="card-body">
                    <ul class="conversation-list" style="max-height: 537px; min-height: 537px; overflow-x: auto;">
                    </ul>

                    <div class="row">
                        <div class="col">
                            <div class="mt-2 bg-light p-3 rounded">
                                <form class="needs-validation" novalidate="" name="chat-form" id="form-chat"
                                    data-id="-1">
                                    <div class="row">
                                        <div class="col mb-2 mb-sm-0">
                                            <input type="text" class="form-control border-0" placeholder="Enter message"
                                                required="" id="message">
                                            <div class="invalid-feedback">
                                                Please enter your messsage
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-light"><i
                                                        class="uil uil-paperclip"></i></a>
                                                <a href="#" class="btn btn-light"> <i class='uil uil-smile'></i>
                                                </a>
                                                <button type="submit" class="btn btn-success chat-send btn-block"><i
                                                        class='uil uil-message'></i></button>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </form>
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div>
        <!-- end chat area-->

        <!-- end user detail -->
    </div> <!-- end row-->
@endsection

@push('js')
    @auth
        <script>
            $(document).ready(function() {
                $('.user-chat').on('click', function() {

                    $('.media.bg-light').removeClass('bg-light');
                    var mediaDiv = $(this).children('.media');
                    mediaDiv.addClass('bg-light');

                    var dataId = $(this).data("id");

                    $.ajax({
                        type: "POST",
                        url: "/api/getHistory",
                        data: {
                            sender_id: {{ Auth::id() }},
                            receiver_id: dataId
                        },
                        dataType: "json",
                        success: function(response) {
                            setMgs(response.data);
                        }
                    });

                    $(".needs-validation").attr('data-id', dataId);
                });

                function setMgs(data) {
                    var mainBox = $(".conversation-list");
                    mainBox.empty();
                    $.each(data, function(index, value) {
                        if (value.sender_id == 1) {
                            mainBox.append(`<li class="clearfix odd">
                            <div class="chat-avatar">
                                <img src="{{ asset('assets_admin/images/users/avatar-1.jpg') }}" class="rounded"
                                    alt="dominic" />
                                <i>10:01</i>
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                    <i>Dominic</i>
                                    <p>
                                        ${value.message}
                                    </p>
                                </div>
                            </div>
                        </li>`);
                        } else {
                            mainBox.append(`<li class="clearfix">
                            <div class="chat-avatar">
                                <img src="{{ asset('assets_admin/images/users/avatar-5.jpg') }}" class="rounded"
                                    alt="Shreyu N" />
                                <i>10:00</i>
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                    <i>Shreyu N</i>
                                    <p>
                                        ${value.message}
                                    </p>
                                </div>
                            </div>
                        </li>`);
                        }
                    });
                }
            });
        </script>
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script>
            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: 'ap1'
            });
            const channel = pusher.subscribe(`user.{{ Auth::id() }}`);
            //Receive messages
            channel.bind('chat', function(data) {
                console.log(data);
                var dataId = $('#form-chat').attr('data-id');
                if (data.sender_id == dataId) {
                    var mainBox = $(".conversation-list");
                    mainBox.append(`<li class="clearfix">
                            <div class="chat-avatar">
                                <img src="{{ asset('assets_admin/images/users/avatar-5.jpg') }}" class="rounded"
                                    alt="Shreyu N" />
                                <i>10:00</i>
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                    <i>Shreyu N</i>
                                    <p>
                                        ${data.message}
                                    </p>
                                </div>
                            </div>
                        </li>`);
                } else {

                    $('.notifi-user').each(function() {
                        var dataIdValue = $(this).data('id');
                        if (dataIdValue == data.sender_id) {
                            var content = $(this).text();
                            $(this).html(parseInt(content) + 1);
                            var DivMediaBody = $(this).closest('.media-body');
                            DivMediaBody.find('.mgs').html(data.message);
                        }
                    });
                }
            });

            //Broadcast messages
            $("#form-chat").submit(function(event) {
                event.preventDefault();
                var dataId = $(this).attr('data-id');
                console.log('dã gửi form', dataId);
                $.ajax({
                    url: "/chat/broadcast/" + dataId,
                    method: 'POST',
                    headers: {
                        'X-Socket-Id': pusher.connection.socket_id
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        message: $("#form-chat #message").val(),
                    }
                }).done(function(mgs) {
                    console.log(mgs);
                    var mainBox = $(".conversation-list");
                    mainBox.append(`<li class="clearfix odd"><div class="chat-avatar"><img src="{{ asset('assets_admin/images/users/avatar-1.jpg') }}" class="rounded"alt="dominic" /><i>10:01</i></div><div class="conversation-text"><div class="ctext-wrap"><i>Admin</i><p>${mgs}</p></div></div></li>
                    `);
                });
            });
        </script>
    @endauth
@endpush
