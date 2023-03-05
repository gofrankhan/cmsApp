@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-lg-8">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title"> Update Client Information</h4>
                </div>
                <div class="row bottom-space"></div>
                @if(count($errors))
                    @foreach ($errors->all() as $error)
                    <p class="alert alert-danger alert-dismissible fade show"> {{ $error}} </p>
                    @endforeach
                @endif
                <form method="post" action="{{ route('client.update', $user->id)}}">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="name" placeholder="Name" type="text" id="name" value="{{ $user->name }}">
                        </div>
                    </div>
                    @php
                        $admin_selection = "selected";
                        $user_selection = "";
                        if(strtolower($user->user_type) == 'user') {
                            $admin_selection = "";
                            $user_selection = "selected";
                        }
                    @endphp
                    <div class="row mb-3">
                        <label for="usertype" class="col-sm-2 col-form-label">User Type</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="usertype" aria-label="Default select example" id="usertype">
                                <option {{ $user_selection }} value="user">User</option>
                                <option {{ $admin_selection }} value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="username" placeholder="Username" type="text" id="username" value="{{ $user->username }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="email" placeholder="Email" type="email" id="email" value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="shop_name" class="col-sm-2 col-form-label">Shop Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="shop_name" placeholder="Shop Name" type="text" id="shop_name" value="{{ $user->shop_name }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <input  type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Update">
                        </div>
                    </div>             
                </form>
            </div>
        </div>
    </div>
</div>


@endsection