@extends('admin.layouts.master')
@section('content')
<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mt-3">
                <div class="login_form_inner">
                    <h3>Change Password</h3>
                    <form class="row login_form" action="{{ route('admin.setting.change') }}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="col-md-12 form-group">
                            <input readonly type="text" class="form-control" name="email" value="{{ auth()->user()->email }}">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" placeholder="Current Password" required>
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="New Password" required>
                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" placeholder="Re-Password" required>
                            @error('new_password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@endsection
