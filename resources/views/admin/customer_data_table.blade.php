@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer Informations</h4>
                        <p class="card-title-desc" >
                            <div align="right">
                                <a href="{{ route('customer.new') }}" class="btn btn-primary waves-effect waves-light">New</a>
                            </div>
                        </p>

                        <table id="customer_datatable" class="table table-bordered customer_datatable">
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

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div>
</div>

@endsection

