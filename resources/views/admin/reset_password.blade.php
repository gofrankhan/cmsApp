@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-lg-8">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Reset Password for User</h4>
                </div>
                <div class="row bottom-space"></div>
                @if(count($errors))
                    @foreach ($errors->all() as $error)
                    <p class="alert alert-danger alert-dismissible fade show"> {{ $error}} </p>
                    @endforeach
                @endif

                <form method="post" action="{{ route('store.new_password') }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="username" type="text" id="username">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="newpassword" class="col-sm-3 col-form-label">New Password</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="newpassword" type="password" id="newpassword">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="confirm_password" type="password" id="confirm_password">
                        </div>
                    </div>

                    <input type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Reset Password">
                </form>
            </div>
        </div>
    </div>
</div>

@endsection