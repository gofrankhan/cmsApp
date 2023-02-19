@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Customer's Information</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('customer.data')}}">Customers</a></li>
                        </ol>
                    </div>
                </div>
                <p class="card-title-desc" >
                    <div align="right">
                        <a href="{{ route('customer.new') }}" class="btn btn-primary waves-effect waves-light">New</a>
                    </div>
                </p>

                <table data-page-length='50' id="customer_datatable" class="table table-bordered customer_datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Tax ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                
                    <tbody></tbody>
                </table>
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div>
</div>

@endsection

