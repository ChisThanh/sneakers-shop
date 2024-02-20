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
                                <th>Product</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                {{-- <th>Desciption</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr>
                                <td>
                                    <p>VI - ASOS Ridley High Waist</p>
                                    <p>EN - ASOS Ridley High Waist</p>
                                </td>
                                <td><img src="{{ asset('assets_admin/images/products/product-1.jpg') }}" alt="image"
                                        width="70" height="70">
                                </td>
                                <td>$79.49</td>
                                <td><span class="badge badge-primary">82 Pcs</span></td>
                                <td>$6,518.18</td>
                                <td class="table-action">
                                    <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                    <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->

    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end" id="pagination">
            {{-- <li class="page-item disabled">
                <a class="page-link" href="javascript: void(0);" tabindex="-1">Previous</a>
            </li>
            {{-- <li class="page-item"><a class="page-link" href="javascript: void(0);">1</a></li>
            <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
            <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
            <li class="page-item"> --}}
            {{-- <a class="page-link" href="javascript: void(0);">Next</a>
            </li> --}}
        </ul>
    </nav>
@endsection
@push('js')
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
                            `<td><p>VI - ${viTranslation.name}</p><p>EN - ${enTranslation.name}</p></td>`)
                        .append(
                            `<td><img src="{{ asset('assets_admin/images/products/product-1.jpg') }}" alt="image" width="70" height="70"></td>`
                        )
                        .append(`<td>${v.price} VND</td>`)
                        .append(
                            `<td><span class="badge badge-primary">${v.stock_quantity} Cái</span></td>`
                        )
                        // .append(`<td>
                    //         <p>VI - ${viTranslation.description}</p>
                    //         <p>EN - ${enTranslation.description}</p>
                    //     </td>`)
                        .append(`<td class="table-action">
                    <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                    <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                </td>`);
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
                        alert("Thành công");
                    },
                    error: function(response) {
                        alert(response.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endpush
