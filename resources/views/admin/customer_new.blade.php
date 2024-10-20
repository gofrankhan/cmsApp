@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('select#subscription').change(function(e){
            var selectValue = $(this).children("option:selected").val();
            $('#modal_subscription').modal('show');
            $('select#subscription_type').val(selectValue);
            
            var now = new Date();
            var month = (now.getMonth() + 1);   
            var month6 = (now.getMonth() - 6);               
            var day = now.getDate();
            if (month < 10) 
                month = "0" + month;
            if (day < 10) 
                day = "0" + day;
            var today = now.getFullYear() + '-' + month + '-' + day;

            var now = new Date();
            now.setMonth(now.getMonth() + 6);
            var month6 = (now.getMonth() + 1);                 
            var day = now.getDate();
            if (month6 < 10) 
                month6 = "0" + month6;
            if (day < 10) 
                day = "0" + day;
            var today_6_month = now.getFullYear() + '-' + month6 + '-' + day;

            $('#start_date').val(today);
            $('#end_date').val(today_6_month);
        });
    });
</script>
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
                            <li class="breadcrumb-item"><a href="{{ route('customer.data.simple')}}">Customers</a></li>
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
                        <label for="email" class="col-sm-2 col-form-label">City Of Birth</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="cityofbirth" placeholder="City Of Birth" type="text" id="cityofbirth">
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
                        <label for="subscription" class="col-sm-2 col-form-label">Subscription</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="subscription" aria-label="Default select example" id="subscription">
                                <option selected="" hidden></option>
                                <option value="basic">Basic</option>
                                <option value="plus">Plus</option>
                                <option value="premier">Premier</option>
                            </select>
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
        <div id="modal_subscription" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Subscription</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" id="form_subscription">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="mb-3">
                                            <label  class="form-label">Subscription Type</label>
                                            <select class="form-select" id="subscription_type" name="subscription_type">
                                                <option value="basic" selected>Basic</option>
                                                <option value="plus" selected>Plus</option>
                                                <option value="premier" selected>Premier</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea type="text" id="description" class="form-control"
                                                placeholder="Descriptioin" name="description">
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label  class="form-label">Start Date</label>
                                                <input type="date" id="start_date" class="form-control" name="start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label  class="form-label">End Date</label>
                                                <input type="date" id="end_date" class="form-control" name="end_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancel</button>
                                    <button id="submit-subscription" type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div><!-- end col-->
    </div>
</div>


@endsection