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
    <div class="row mb-3">
        <div class="col-12">


            <form method="POST" action="{{ route('admin.brand.update', ['id' => $brand->id]) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="inputNamel4" class="col-form-label">Name</label>
                    <input type="text" class="form-control" id="inputNamel4" placeholder="Name" name="name"
                        value="{{ $brand->name }}" id="name">
                    <div class="text-danger " id="name-error"></div>

                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Brand</button>

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
                                "{{ route('admin.brand.index') }}";
                        }, 1000);
                    },
                    error: function(response) {
                        $form.unbind('submit').submit();
                    }
                });
            });
        });
    </script>
@endpush
