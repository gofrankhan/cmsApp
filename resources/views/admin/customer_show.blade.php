@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

    function close_window() {
            close();
        }
</script>

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title"> Show Customer's Information</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.data')}}">Customers</a></li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>
                </div>
                <hr><hr>
                <form action="{{ route('customer.edit', $customer->id)}}">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Tax ID</label>
                        <div class="col-sm-10">
                            {{ $customer->taxid }}
                        </div>
                    </div>
                    @if($customer->customertype == 'company')
                    <div class="row mb-3" id="div_company">
                        <label id="lbl_company"  for="email" class="col-sm-2 col-form-label">Company</label>
                        <div class="col-sm-10">
                           {{ $customer->company }}
                        </div>
                    </div>
                    @else
                    <div class="row mb-3" id="div_firstname">
                        <label id="lbl_firstname" for="email" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-10">
                            {{ $customer->firstname }}
                        </div>
                    </div>
                    <div class="row mb-3" id="div_lastname">
                        <label id="lbl_lastname" for="email" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                            {{ $customer->lastname }}
                        </div>
                    </div>
                    @endif
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-sm-10">
                           {{ $customer->mobile }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Date of Birth</label>
                        <div class="col-sm-10">
                            {{ date("d/m/Y", strtotime($customer->dateofbirth)) }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Citizenship</label>
                        <div class="col-sm-10">
                            {{ $customer->citizenship }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Address Line 1</label>
                        <div class="col-sm-10">
                            {{ $customer->addressline1 }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-10">
                            {{ $customer->city }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Region</label>
                        <div class="col-sm-10">
                            {{ $customer->region }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Postcode</label>
                        <div class="col-sm-10">
                            {{ $customer->postcode }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <input type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Edit">
                            <input type="submit" onclick="close_window();return false;" class="btn btn-danger btn-rounded waves-effect waves-light" value="Close">
                        </div>
                    </div>              
                </form>
            </div>
        </div>
    </div>
</div>


@endsection