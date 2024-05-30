@extends('admin.layouts.master')
@section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="assets_admin/css/styles.css" />

    <div id="wrapper">
        <div class="content-area">
            <div class="container-fluid">
                <div class="main">
                    <div class="row sparkboxes mt-4 mb-4">
                        <div class="col-md-4">
                            <div class="box box1">
                                <div id="spark1"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box box2">
                                <div id="spark2"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box box3">
                                <div id="spark3"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 mb-4">
                        <div class="col-md-6">
                            <div class="box">
                                <div id="bar"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box">
                                <div id="donut"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 mb-4">
                        <div class="col-md-6">
                            <div class="box">
                                <div id="area"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box">
                                <div id="line"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.slim.min.js"></script>
    <script src="assets_admin/js/apexcharts.js"></script>
    <script src="assets_admin/js/data.js"></script>
    <script src="assets_admin/js/scripts.js"></script>

    <script></script>
@endsection
