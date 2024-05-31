@extends('admin.layouts.master')
@section('content')
    <div class="content-page">
        <div class="content">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card widget-inline">
                        <div class="card-body p-0">
                            <div class="row no-gutters">
                                <div class="col-sm-6 col-xl-3">
                                    <div class="card shadow-none m-0">
                                        <div class="card-body text-center">
                                            <i class="dripicons-briefcase text-muted" style="font-size: 24px;"></i>
                                            <h3><span>{{ $quantityBill }}</span></h3>
                                            <p class="text-muted font-15 mb-0">Total Bill</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xl-3">
                                    <div class="card shadow-none m-0 border-left">
                                        <div class="card-body text-center">
                                            <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i>
                                            <h3><span>{{ $quantityUser }}</span></h3>
                                            <p class="text-muted font-15 mb-0">Members</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xl-3">
                                    <div class="card shadow-none m-0 border-left">
                                        <div class="card-body text-center">
                                            <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                            <h3><span>{{ $quantityProduct }}</span></h3>
                                            <p class="text-muted font-15 mb-0">Total product</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xl-3">
                                    <div class="card shadow-none m-0 border-left">
                                        <div class="card-body text-center">
                                            <i class="dripicons-graph-line text-muted" style="font-size: 24px;"></i>
                                            <h3><span>{{ $totalBill }} VND</span> <i
                                                    class="mdi mdi-arrow-up text-success"></i></h3>
                                            <p class="text-muted font-15 mb-0">Total money</p>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                        </div>
                    </div> <!-- end card-box-->
                </div> <!-- end col-->
            </div>
            <!-- end row-->


            <div class="row">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Thể loại</h4>
                            <div class="my-4 chartjs-chart" style="height: 202px;">
                                <canvas id="project-status-chart"></canvas>
                            </div>
                            <div class="row text-center mt-2 py-2 " id="labels">
                            </div>
                            <!-- end row-->
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Đơn hàng theo tháng</h4>
                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                <canvas id="task-area-chart" data-bgColor="#536de6" data-borderColor="#536de6"></canvas>
                            </div>
                            <div class="row text-center mt-2 py-2">
                            </div>
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>
                <!-- end row-->


                <div class="row">

                </div>
                <!-- end row-->
            </div>
        </div>
    @endsection

    @push('js')
        <script src="{{ asset('assets_admin/js/vendor/Chart.bundle.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.getChartData') }}",
                    dataType: "json",
                    success: function(response) {
                        const months = response.data.map(item => "Tháng " + item.month);
                        const totals = response.data.map(item => item.total);
                        areaChart(months, totals);
                    }
                });

                function areaChart(months, totals) {
                    var ctx = $("#task-area-chart").get(0).getContext("2d");
                    new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: months,
                            datasets: [{
                                label: "Tiền",
                                backgroundColor: "#727cf5",
                                borderColor: "#727cf5",
                                data: totals
                            }]
                        },
                        options: {
                            legend: {
                                display: false
                            }
                        }
                    });
                }

                function formatTxt(str) {
                    if (str.length > 5) {
                        return str.substring(0, 5) + '...';
                    }
                    return str;
                }

                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.getChartCategories') }}",
                    dataType: "json",
                    success: function(response) {
                        const names = response.data.map(item => item.name);
                        const percentages = response.data.map(item => parseInt(item.percentage));
                        statusChart(names, percentages);
                        response.data.forEach(v => {
                            $("#labels").append(`
                                <div class="col">
                                    <i class="mdi mdi-trending-up text-success mt-3 h3"></i>
                                    <h5 class="font-weight-normal">
                                        <span>${v.percentage}%</span>
                                    </h5>
                                    <p class="text-muted mb-0">${formatTxt(v.name)}</p>
                                </div>
                            `);
                        });


                    }
                });

                function statusChart(names, percentages) {
                    var ctx1 = $("#project-status-chart").get(0).getContext("2d");
                    new Chart(ctx1, {
                        type: "doughnut",
                        data: {
                            labels: names,
                            datasets: [{
                                data: percentages,
                                backgroundColor: ["#0acf97", "#727cf5", "#fa5c7c", "#f9c851",
                                    "#343a40"
                                ],
                                borderWidth: "3"
                            }]
                        },
                        options: {
                            maintainAspectRatio: !1,
                            legend: {
                                display: false
                            }
                        }
                    })
                }

            });
        </script>
    @endpush
