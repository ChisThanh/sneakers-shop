@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Brands</li>
                    </ol>
                </div>
                <h4 class="page-title">Brands</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="{{ route('admin.brand.create') }}" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle mr-2"></i> Add Brands</a>
                        </div>
                    </div>
                    {{-- table --}}
                    <table class="table table-hover table-centered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Brand Name</th>
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

            function fetchData(page, query = '') {
                $.ajax({
                    url: "{{ route('api.brand.index') }}" + `?page=${page}&query=${query}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        updateUI(data);
                        updatePagination(data, query);
                    },
                    error: function(error) {
                        alert(error);
                    }
                });
                const newUrl = window.location.pathname + `?page=${page}` + (query ? `&query=${query}` : '');
                history.pushState({
                    page: page
                }, null, newUrl);
            }

            function updateUI(data) {
                $('tbody').empty();
                $.each(data.data, function(i, v) {
                    $('tbody').append('<tr>')
                        .append(`<td>${v.id}</td>`)
                        .append(`<td>${v.name}</td>`)
                        .append(
                            `<td class="table-action">
                            <a href="/admin/brand/edit/${v.id}" class="action-icon"> 
                                <i class="mdi mdi-pencil"></i></a>
                            <a href="##" class="action-icon btn-delete" data-id='${v.id}'> 
                                <i class="mdi mdi-delete"></i></a>
                        </td>`
                        );
                });
            }

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
                        url: `/admin/brand/destroy/${dataId}`,
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
                }).catch(swal.noop);
            });

            function updatePagination(data, query) {
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
                        fetchData(currentPage, query);
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
                        fetchData(currentPage, query);
                    });
                    pageLink.on('click', function(e) {
                        e.preventDefault();
                        currentPage = i;
                        fetchData(currentPage, query);
                    });
                    paginationContainer.append(pageLink);
                }

                const nextPageLink = $('<li class="page-item">').append($(
                    '<a class="page-link" href="##" aria-label="Next">').html('&raquo;'));
                nextPageLink.click(function(e) {
                    e.preventDefault();
                    if (currentPage < data.last_page) {
                        currentPage++;
                        fetchData(currentPage, query);
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
        });
    </script>
@endpush
