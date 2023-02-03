@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Files Informations</h4>
                        <p class="card-title-desc" >
                            <div align="right">
                                <a href="" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">New</a>
                            </div>
                        </p>

                        <table id="file_datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tax ID</th>
                                    <th>Customer</th>
                                    <th>Shop</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        
                            <tbody></tbody>
                        </table>

                        @php
                            $categories = App\Models\Category::all();
                        @endphp

                        <!-- sample modal content -->
                        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">New File</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label  class="form-label">Service Category</label>
                                                        <select class="form-select" >
                                                            <option value="Choose">Choose...</option>
                                                            @foreach ($categories as $category)
                                                            <option value="{{ $category->category }}">{{ $category->category }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label  class="form-label">Service</label>
                                                        <select class="form-select" >
                                                            <option selected disabled value="">Choose...</option>
                                                            <option>...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div>
                                                    <div class="mb-3">
                                                        <label  class="form-label">Tax ID</label>
                                                        <input type="text" class="form-control
                                                            placeholder="Tax ID" value="Mark">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div>
                                                    <div class="mb-3">
                                                        <label  class="form-label">Customer Type</label>
                                                        <input type="text" class="form-control
                                                            placeholder="Customer Type" value="Mark">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label  class="form-label">First name</label>
                                                        <input type="text" class="form-control
                                                            placeholder="First name" value="Mark">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Last name</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Last name" value="Otto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label  class="form-label">Date of birth</label>
                                                        <input type="date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Telephone</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Telephone" value="Otto">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary waves-effect waves-light">Create</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div>
</div>

@endsection

