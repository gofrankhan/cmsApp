@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-lg-8">
                <h4 class="card-title"> Add New Client</h4><hr><hr>
                @if(count($errors))
                    @foreach ($errors->all() as $error)
                    <p class="alert alert-danger alert-dismissible fade show"> {{ $error}} </p>
                    @endforeach
                @endif
                <form method="post" action="{{ route('client.store')}}">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="name" placeholder="Name" type="text" id="name" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="usertype" class="col-sm-2 col-form-label">User Type</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="usertype" aria-label="Default select example" id="usertype">
                                <option selected="" hidden></option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="username" placeholder="Username" type="text" id="username">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="email" placeholder="Email" type="email" id="email">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="password" placeholder="Password" type="password" id="password">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="password_confirmation" placeholder="Confirm Password" type="password" id="password_confirmation">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <input  type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Create">
                        </div>
                    </div>              
                </form>
            </div>
        </div>
    </div>
</div>

@endsection