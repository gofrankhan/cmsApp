@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('select#shop_name').change(function(e){
            $('#div_new_shop').hide();
            var selectValue = $(this).children("option:selected").val();
            if(selectValue === "create_new"){
                $('#div_new_shop').show();
            }else{
                $('#div_new_shop').hide();
            }
        });
    });
</script>

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-lg-8">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title"> Add New Client</h4>
                </div>
                <div class="row bottom-space"></div>
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
                        <label for="email" class="col-sm-2 col-form-label">Select Shop</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="shop_name" aria-label="Default select example" id="shop_name">
                                <option selected value="create_new">Create New Shop</option>
                                @php 
                                    $shops = App\Models\User::select('shop_name')->distinct()->get();
                                @endphp
                                @foreach ($shops as $shop)
                                <option value="{{ $shop->shop_name }}">{{ $shop->shop_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3" id="div_new_shop">
                        <label for="email" class="col-sm-2 col-form-label">New Shop Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="new_shop" placeholder="New Shop Name" type="text" id="new_shop" >
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