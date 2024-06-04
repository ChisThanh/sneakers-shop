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
                <h4 class="page-title">Users</h4>
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
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
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
                url: "{{ route('api.user.index') }}" + `?page=${page}&query=${query}`,
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
            history.pushState({page: page}, null, newUrl);
        }

        function updateUI(data) {
            $('tbody').empty();
            $.each(data.data, function(i, v) {
                if(v.role == 1)
                {
                    $('tbody').append('<tr>')
                    .append(`<td>${v.id}</td>`)
                    .append(`<td>${v.name}</td>`)
                    .append(`<td>${v.firstname}</td>`)
                    .append(`<td>${v.lastname}</td>`)
                    .append(`<td>${v.email}</td>`)
                    .append(`<td>${v.phone}</td>`)
                    .append(`<td>${v.address}</td>`)    
                }
            });
        }

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
