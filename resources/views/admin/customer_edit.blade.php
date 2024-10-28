@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@php 
    $user_type = Auth::user()->user_type;
    $is_admin = ($user_type == 'admin');
@endphp

<script>
    $(document).ready(function(){
        $('#cancel_subscription').click(function(e){
            $('select#subscription').val('none');
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('#save_subscription').click(function(e){
            var description = $('#description').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            $('#description1').val(description);
            $('#start_date1').val(start_date);
            $('#end_date1').val(end_date);
        });
    });
</script>

<script>
    function getEndDate(months){
        var now = new Date();
        now.setMonth(now.getMonth() + months);
        var month = (now.getMonth() + 1);                 
        var day = now.getDate();
        if (month < 10) 
            month = "0" + month;
        if (day < 10) 
            day = "0" + day;
        var today_end_date = now.getFullYear() + '-' + month + '-' + day;
        return today_end_date
    }
</script>

<script>
    $(document).ready(function(){
        $('select#subscription').change(function(e){
            var selectValue = $(this).children("option:selected").val();
            if(selectValue == 'none') return;
            $('#modal_subscription').modal('show');
            $('select#subscription_type').val(selectValue);
            
            var now = new Date();
            var month = (now.getMonth() + 1);             
            var day = now.getDate();
            if (month < 10) 
                month = "0" + month;
            if (day < 10) 
                day = "0" + day;
            var today = now.getFullYear() + '-' + month + '-' + day;

            var end_date;
            if(selectValue == 'basic')
                end_date = getEndDate(1);
            else if(selectValue == 'plus')
                end_date = getEndDate(3);
            else if(selectValue == 'premier')
                end_date = getEndDate(6);
            else if(selectValue == 'enterprise')
                end_date = getEndDate(12);
            $('#start_date').val(today);
            $('#end_date').val(end_date);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('select#subscription_type').change(function(e){
            var selectValue = $(this).children("option:selected").val();
            
            var end_date;
            if(selectValue == 'basic')
                end_date = getEndDate(1);
            else if(selectValue == 'plus')
                end_date = getEndDate(3);
            else if(selectValue == 'premier')
                end_date = getEndDate(6);
            else if(selectValue == 'enterprise')
                end_date = getEndDate(12);
            $('#end_date').val(end_date);
        });
    });
</script>

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Edit Customer Information</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.data.simple')}}">Customers</a></li>
                            <li class="breadcrumb-item active">Edit Customer</li>
                        </ol>
                    </div>
                </div>
                <div class="row bottom-space"></div>
                <form method="post" action="{{ route('customer.update', $customer->id)}}">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Tax ID</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="taxid" placeholder="Tax ID" type="text" id="taxid" value="{{ $customer->taxid }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="username" class="col-sm-2 col-form-label">Customer Type</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="customertype" aria-label="Default select example" id="customertype" value="{{ $customer->customertype }}">
                                <option selected="" hidden></option>
                                @if($customer->customertype == 'company')
                                <option selected value="company">Company</option>
                                <option value="person">Person</option>
                                @else
                                <option value="company">Company</option>
                                <option selected value="person">Person</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3" id="div_company">
                        <label id="lbl_company"  for="email" class="col-sm-2 col-form-label">Company</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="company" placeholder="Company" type="text" id="company" value="{{ $customer->company }}">
                        </div>
                    </div>
                    <div class="row mb-3" id="div_firstname">
                        <label id="lbl_firstname" for="email" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="firstname" placeholder="First Name" type="text" id="firstname" value="{{ $customer->firstname }}">
                        </div>
                    </div>
                    <div class="row mb-3" id="div_lastname">
                        <label id="lbl_lastname" for="email" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="lastname" placeholder="Last Name" type="text" id="lastname" value="{{ $customer->lastname }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Telephone</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="telephone" placeholder="Telephone" type="text" id="telephone" value="{{ $customer->telephone }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="mobile" placeholder="Mobile" type="text" id="mobile" value="{{ $customer->mobile }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Date of Birth</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="dateofbirth" type="date" id="dateofbirth" value="{{ $customer->dateofbirth }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">City Of Birth</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="cityofbirth" placeholder="City Of Birth" type="text" id="cityofbirth" value="{{ $customer->pob }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Citizenship</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="citizenship" placeholder="Citizenship" type="text" id="citizenship" value="{{ $customer->citizenship }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Address Line 1</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="addressline1" placeholder="Address Line 1"  type="text" id="addressline1" value="{{ $customer->addressline1 }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Address Line 2</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="addressline2" placeholder="Address Line 2" type="text" id="addressline2" value="{{ $customer->addressline2 }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="city" placeholder="City" type="text" id="city" value="{{ $customer->city }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Region</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="region" placeholder="Region" type="text" id="region" value="{{ $customer->region }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Postcode</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="postcode" placeholder="postcode" type="text " id="postcode" value="{{ $customer->postcode }}">
                        </div>
                    </div>
                    @if($is_admin)
                    <input class="form-control" name="description1" placeholder="description" type="text " id="description1" value="{{ $subscription->description }}" hidden>
                    <input type="date" id="start_date1" class="form-control" name="start_date1" value="{{ $subscription->start_date }}" hidden>
                    <input type="date" id="end_date1" class="form-control" name="end_date1" value="{{ $subscription->end_date }}" hidden>
                    
                    <div class="row mb-3">
                        <label for="subscription" class="col-sm-2 col-form-label">Subscription</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="subscription" aria-label="Default select example" id="subscription">
                                <option selected="Choose Subscription ..." hidden>Choose Subscription...</option>
                                @if( $subscription->subscription_type == 'basic')
                                <option value="basic" selected>Basic - 1 Month</option>
                                <option value="plus">Plus - 3 Months</option>
                                <option value="premier">Premier - 6 Months</option>
                                <option value="enterprise">Enterprise - 1 Year</option>
                                <option value="none">None</option>
                                @elseif( $subscription->subscription_type == 'plus')
                                <option value="basic" >Basic - 1 Month</option>
                                <option value="plus" selected>Plus - 3 Months</option>
                                <option value="premier">Premier - 6 Months</option>
                                <option value="enterprise">Enterprise - 1 Year</option>
                                <option value="none">None</option>
                                @elseif( $subscription->subscription_type == 'premier')
                                <option value="basic" >Basic - 1 Month</option>
                                <option value="plus" >Plus - 3 Months</option>
                                <option value="premier" selected>Premier - 6 Months</option>
                                <option value="enterprise">Enterprise - 1 Year</option>
                                <option value="none">None</option>
                                @elseif( $subscription->subscription_type == 'enterprise')
                                <option value="basic" >Basic - 1 Month</option>
                                <option value="plus" >Plus - 3 Months</option>
                                <option value="premier">Premier - 6 Months</option>
                                <option value="enterprise" selected>Enterprise - 1 Year</option>
                                <option value="none">None</option>
                                @else
                                <option value="basic" >Basic - 1 Month</option>
                                <option value="plus" >Plus - 3 Months</option>
                                <option value="premier">Premier - 6 Months</option>
                                <option value="enterprise" selected>Enterprise - 1 Year</option>
                                <option value="none" selected>None</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-8">
                            <input  type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Update">
                        </div>
                    </div>              
                </form>
            </div>
        </div>
        @if($is_admin)
        <div id="modal_subscription" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Subscription</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3">
                                <label  class="form-label">Subscription Type</label>
                                <select class="form-select" id="subscription_type" name="subscription_type">
                                    <option value="basic" selected>Basic - 1 Month</option>
                                    <option value="plus" selected>Plus - 3 Months</option>
                                    <option value="premier" selected>Premier - 6 Months</option>
                                    <option value="enterprise" selected>Enterprise - 1 Year</option>
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
                                    <input type="date" id="start_date" class="form-control" name="start_date" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label  class="form-label">End Date</label>
                                    <input type="date" id="end_date" class="form-control" name="end_date" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="cancel_subscription" type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancel</button>
                        <button id="save_subscription" type="submit" class="btn btn-primary waves-effect waves-light" data-bs-dismiss="modal">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        @endif
    </div><!-- end col-->
    </div>
</div>


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

@endsection