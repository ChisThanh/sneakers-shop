@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Carts</li>
                    </ol>
                </div>
                <h4 class="page-title">Bills</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- table --}}
                    <table class="table table-hover table-centered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Total</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-main">
                        </tbody>
                    </table>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->

    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end" id="pagination">

        </ul>
    </nav>
    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Cart Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-centered mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-modal">

                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@push('css')
    <link href="{{ asset('assets_admin/css/vendor/swal2.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    <script src="{{ asset('assets_admin/js/vendor/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function() {
            const paginationContainer = $('#pagination');
            let currentPage = 1;


            function fetchData(page) {
                $.ajax({
                    url: "{{ route('api.bill.index') }}" + `?page=${page}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        updateUI(data);
                        updatePagination(data);
                    },
                    error: function(error) {
                        alert(error);
                    }
                });
                const newUrl = window.location.pathname + `?page=${page}`;
                history.pushState({
                    page: page
                }, null, newUrl);
            }

            function updateUI(data) {
                $('#tbody-main').empty();
                $.each(data.data, function(i, v) {
                    var select = $('<select class="custom-select select-status">');
                    $.each(v.status_array, function(i, v) {
                        select.append(`<option value="${v}">${v}</option>`)
                    });

                    $('tbody').append('<tr>')
                        .append(`<td>${v.id}</td>`)
                        .append(`<td>${v.user_name}</td>`)
                        .append(`<td>${v.total}</td>`)
                        .append(`<td>${v.delivery_date}</td>`)
                        .append($(`<td data-id="${v.id}">`).append(select))
                        .append(
                            `<td class="table-action">
                                <a href="##" class="action-icon btn-detail" data-id='${v.id}'>
                                    <i class="mdi mdi-eye-outline"></i>
                                </a>
                                <a target="_blank" href="/bill/view-invoice-pdf/${v.id}" class="action-icon">
                                    <i class="mdi mdi-pdf-box"></i>
                                </a>
                                <a href="/bill/down-invoice-pdf/${v.id}" class="action-icon">
                                    <i class="mdi mdi-cloud-download"></i>
                                </a>

                            </td>`
                        );
                });
            }


            function updatePagination(data) {

                paginationContainer.empty();

                if (data.last_page < currentPage) {
                    currentPage = data.last_page;
                }
                const prevPageLink = $('<li class="page-item">').append($(
                    '<a class="page-link" href="##" aria-label="Previous">').html('&laquo;'));
                prevPageLink.click(function(e) {
                    e.preventDefault();
                    if (currentPage > 1) {
                        currentPage--;
                        fetchData(currentPage);
                    }
                });
                paginationContainer.append(prevPageLink);

                for (let i = 1; i <= data.last_page; i++) {
                    const pageLink = $('<li class="page-item">').append($('<a class="page-link" href="##">').text(
                        i));
                    if (i === currentPage) {
                        pageLink.addClass('active');
                    }
                    pageLink.click(function() {
                        currentPage = i;
                        fetchData(currentPage);
                    });
                    pageLink.on('click', function(e) {
                        e.preventDefault();
                        currentPage = i;
                        fetchData(currentPage);
                    });
                    paginationContainer.append(pageLink);
                }

                const nextPageLink = $('<li class="page-item">').append($(
                    '<a class="page-link" href="##" aria-label="Next">').html('&raquo;'));
                nextPageLink.click(function(e) {
                    e.preventDefault();
                    if (currentPage < data.last_page) {
                        currentPage++;
                        fetchData(currentPage);
                    }
                });
                paginationContainer.append(nextPageLink);
            }

            const urlParams = new URLSearchParams(window.location.search);
            const pageParam = urlParams.get('page');
            if (pageParam) {
                currentPage = parseInt(pageParam);
            }
            fetchData(currentPage);

            $('tbody').on('click', '.btn-detail', function(e) {
                e.preventDefault();
                var dataId = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: `/api/bill/bill-detail/${dataId}`,
                    dataType: "json",
                    success: function(response) {
                        var data = response.data;
                        $('#tbody-modal').empty();
                        $.each(data, function(i, v) {
                            $('#tbody-modal').append(`<tr>
                                    <td>${v.product.name}</td>
                                    <td>${v.price} VND</td>
                                    <td>${v.quantity}</td>
                                    </tr>`);
                        });
                    }
                });
                setTimeout(function() {
                    $('#modal-detail').modal('show');
                }, 300);
            });

            $('tbody').on('change', '.select-status', function(e) {
                var closestTr = $(this).closest('td');
                var dataId = closestTr.attr('data-id');
                var selectedValue = $(this).val();
                swal({
                    title: 'Bạn có chắc chắn thay đổi trình trạng đơn?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-info btn-fill',
                    cancelButtonClass: 'btn btn-danger btn-fill',
                    confirmButtonText: 'Thay đổi',
                    cancelButtonText: 'Hủy',
                    buttonsStyling: false
                }).then(function(result) {
                    $.ajax({
                        type: "GET",
                        url: `/admin/bill/edit/${dataId}`,
                        data: {
                            'status': selectedValue
                        },
                        success: function(response) {
                            swal({
                                title: "Thay đổi thành công!",
                                buttonsStyling: false,
                                type: "success",
                                timer: 1000,
                                showConfirmButton: false
                            }).catch(swal.noop);
                            // fetchData(currentPage);
                        },
                        error: function(response) {
                            swal({
                                title: "Thay đổi không thành công!",
                                buttonsStyling: false,
                                type: "error",
                                timer: 1000,
                                showConfirmButton: false
                            }).catch(swal.noop);
                        }
                    });
                }).catch(swal.noop)
            });

        });
    </script>
@endpush
