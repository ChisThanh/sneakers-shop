@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
                <h4 class="page-title">Products</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="{{ route('admin.product.create') }}" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle mr-2"></i> Add Products</a>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <form action="#" class="d-inline-block">
                                    <label for="file-import" class="btn btn-success mb-2 mr-1">Import
                                        CSV</label>
                                    <input type="file" id="file-import" class="d-none" accept=".csv" name="file">
                                </form>
                                <button type="button" class="btn btn-light mb-2">Export</button>
                            </div>
                        </div><!-- end col-->
                    </div>
                    {{-- table --}}
                    <table class="table table-hover table-centered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
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
                    <h4 class="modal-title" id="myLargeModalLabel">Product Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
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
                    url: "{{ route('api.product.index') }}" + `?page=${page}`,
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
                $('tbody').empty();
                $.each(data.data, function(i, v) {
                    var viTranslation = v.translations.find(translation => translation
                        .locale === 'vi');
                    var enTranslation = v.translations.find(translation => translation
                        .locale === 'en');

                    $('tbody').append('<tr>')
                        .append(`<td>${v.id}</td>`)
                        .append(
                            `<td>${v.name}</td>`)
                        .append(
                            `<td><img src="${v.image}" alt="image" width="70" height="70"></td>`
                            //`<td><img src="{{ asset('assets_admin/images/products/product-1.jpg') }}" alt="image" width="70" height="70"></td>`
                        )
                        .append(`<td>${v.price} VND</td>`)
                        .append(
                            `<td><span class="badge badge-primary">${v.stock_quantity} Cái</span></td>`
                        )
                        .append(
                            `<td class="table-action"><a href="/admin/product/edit/${v.id}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                            <a href="##" class="action-icon btn-delete" data-id='${v.id}'> 
                            <i class="mdi mdi-delete"></i></a><a href="##" class="action-icon btn-detail" data-id='${v.id}'> 
                            <i class="mdi mdi-eye-outline"></i></a></td>`
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
                    url: `/api/product/${dataId}`,
                    dataType: "json",
                    success: function(response) {
                        var data = response.data;
                        $('.modal-body').html(`
                                    <p><b>Name:</b> ${data.name}</p>
                                    <p><b>Description (EN)</b>: ${data.translations.find(t => t.locale === 'en').description}</p>
                                    <p><b>Description (VI)</b>: ${data.translations.find(t => t.locale === 'vi').description}</p>
                                    <p><b>Price</b>: ${data.price}</p>
                                    <p><b>Stock Quantity</b>: ${data.stock_quantity}</p>
                                    <img src="${data.image}" alt="Product Image" width="200">
                                    `);
                    }
                });
                setTimeout(function() {
                    $('#modal-detail').modal('show');
                }, 300);
            });
            $('tbody').on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var dataId = $(this).attr('data-id');
                swal({
                    title: 'Bạn có chắc chắn xóa?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-info btn-fill',
                    cancelButtonClass: 'btn btn-danger btn-fill',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                    buttonsStyling: false
                }).then(function(result) {
                    $.ajax({
                        type: "POST",
                        url: `/admin/product/destroy/${dataId}`,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": 'DELETE'
                        },
                        success: function(response) {
                            swal({
                                title: "Xóa thành công!",
                                buttonsStyling: false,
                                type: "success",
                                timer: 1000,
                                showConfirmButton: false
                            }).catch(swal.noop);
                            fetchData(currentPage);
                        }
                    });
                }).catch(swal.noop)
            });

            var file = $("#file-import");
            file.change(function(e) {
                e.preventDefault();
                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                $.ajax({
                    url: '{{ route('api.product.importCSV') }}',
                    type: "POST",
                    dataType: "json",
                    enctype: 'multipart/form-data',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        fetchData(currentPage);
                        swal({
                            title: "Tải dữ liệu thành công!",
                            buttonsStyling: false,
                            type: "success",
                            timer: 1000,
                            showConfirmButton: false
                        }).catch(swal.noop);
                    },
                    error: function(response) {
                        alert(response.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endpush
