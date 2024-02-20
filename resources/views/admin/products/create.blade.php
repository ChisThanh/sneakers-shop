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
    <div class="row mb-3">
        <div class="col-12">


            <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="inputNamel4" class="col-form-label">Name</label>
                    <input type="text" class="form-control" id="inputNamel4" placeholder="Name" name="name"
                        value="{{ old('name') }}" id="name">
                    <div class="text-danger " id="name-error"></div>

                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputPrice4" class="col-form-label">Price</label>
                        <input type="number" class="form-control" id="inputPrice4" placeholder="Price" name="price"
                            value="{{ old('price') }}">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputQuantitty4" class="col-form-label">Quantitty</label>
                        <input type="number" class="form-control" id="inputQuantitty4" placeholder="Quantitty"
                            name="quantity" value="{{ old('quantity') }}">
                        @error('quantity')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 ">
                        <label for="image" class="btn btn-success ">Upload Image</label>
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <input type="file" id="image" class="d-none" name="image"
                            onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <p>
                            <img id="blah" alt="your image" width="300" height="300"
                                src="{{ asset('assets_admin/images/tmp-image.png') }}" />
                        </p>

                    </div>
                </div>
                <div class="form-group">
                    <label for="description-vi">Description - VI</label>
                    <textarea name="description-vi" id="description-vi" class="summernote" rows="100"></textarea>
                    @error('description-vi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description - EN</label>
                    <textarea name="description-en" id="description-en" class="summernote"></textarea>
                    @error('description-en')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Add Product</button>

            </form>
        </div>
    </div>
@endsection
@push('css')
    <link href="{{ asset('assets_admin/css/vendor/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets_admin/css/vendor/swal2.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    <script src="{{ asset('assets_admin/js/vendor/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets_admin/js/vendor/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function() {
            @error('msg')
                swal({
                    title: '{!! $message !!}',
                    buttonsStyling: false,
                    type: "error",
                    timer: 1500,
                    showConfirmButton: false
                }).catch(swal.noop)
            @enderror
            $('form').submit(function(e) {

                e.preventDefault();
                var $form = $(this);
                var $formData = new FormData($form[0]);

                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: $formData,
                    dataType: "json",
                    async: false,
                    cache: false,
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    success: function(response) {
                        swal({
                            title: "Thành công!",
                            buttonsStyling: false,
                            type: "success",
                            timer: 1000,
                            showConfirmButton: false
                        }).catch(swal.noop)
                        setTimeout(function() {
                            window.location.href =
                                "{{ route('admin.product.index') }}";
                        }, 1000);
                    },
                    error: function(response) {

                        $form.unbind('submit').submit();

                    }
                });

            });



            let timerId;
            $('#description-vi').summernote({
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['insert', ['table']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['misc', ['codeview']]
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        clearTimeout(timerId);
                        timerId = setTimeout(function() {
                            translateApi(contents);
                        }, 1000);
                    }

                }
            });
            $('#description-en').summernote({
                height: 150,
                toolbar: false,
            });

            function translateApi(contents) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('api.translate') }}",
                    data: {
                        text: contents,
                        language: 'en'
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#description-en').summernote('code', response.data);
                    },
                    error: function(response) {
                        alert("Lỗi");
                    },
                });
            }

        });
    </script>
@endpush
