@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('select.form-select').change(function(e){
            var selectValue = $(this).children("option:selected").val();
            if(selectValue === "company"){
                $('#div_firstname').hide();
                $('#div_lastname').hide();
                $('#div_company').show();
            }else{
                $('#div_company').hide();
                $('#div_firstname').show();
                $('#div_lastname').show();
            }
        });
    });
</script>

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title"> Add New Customer</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.data')}}">Customers</a></li>
                            <li class="breadcrumb-item active">New Customer</li>
                        </ol>
                    </div>
                </div>
                <div class="row bottom-space"></div>
                <form method="post" action="{{ route('customer.store')}}">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Tax ID</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="taxid" placeholder="Tax ID" type="text" id="taxid" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="username" class="col-sm-2 col-form-label">Customer Type</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="customertype" aria-label="Default select example" id="customertype">
                                <option selected="" hidden></option>
                                <option value="company">Company</option>
                                <option value="person">Person</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3" id="div_company">
                        <label id="lbl_company"  for="email" class="col-sm-2 col-form-label">Company</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="company" placeholder="Company" type="text" id="company">
                        </div>
                    </div>
                    <div class="row mb-3" id="div_firstname">
                        <label id="lbl_firstname" for="email" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="firstname" placeholder="First Name" type="text" id="firstname">
                        </div>
                    </div>
                    <div class="row mb-3" id="div_lastname">
                        <label id="lbl_lastname" for="email" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="lastname" placeholder="Last Name" type="text" id="lastname">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Telephone</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="telephone" placeholder="Telephone" type="text" id="telephone">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="mobile" placeholder="Mobile" type="text" id="mobile">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Date of Birth</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="dateofbirth" type="date" id="dateofbirth">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Citizenship</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="citizenship" placeholder="Citizenship" type="text" id="citizenship">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Address Line 1</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="addressline1" placeholder="Address Line 1"  type="text" id="addressline1">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Address Line 2</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="addressline2" placeholder="Address Line 2" type="text" id="addressline2">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="city" placeholder="City" type="text" id="city">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Region</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="region" placeholder="Region" type="text" id="region">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Postcode</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="postcode" placeholder="postcode" type="text " id="postcode">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-8">
                            <input  type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Save">
                        </div>
                    </div>              
                </form>
            </div>
        </div>
    </div>
</div>


@endsection