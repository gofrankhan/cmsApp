@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  $(document).ready(function() {
    $('#category').change(function() {
      var value = $(this).val();
      $.ajax({
        url: "{{ route('load.services') }}",
        type: "GET",
        data: { value: value },
        success: function(data) {
          $("#service").empty();
          $("#service").append("<option value=''>Select a service</option>");
          $.each(data, function(index, item) {
            $("#service").append("<option value='" + item.service + "'>" + item.service + "</option>");
          });
        }
      });
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#taxid').change(function() {
      var value = $(this).val();
      $.ajax({
        url: "{{ route('customer.info') }}",
        type: "GET",
        data: { value: value },
        success: function(data) {
          $("#customer_type").val(data.customertype);
          $("#first_name").val(data.firstname);
          $("#last_name").val(data.lastname);
          $("#date_of_birth").val(data.dateofbirth);
          $("#telephone").val(data.telephone);
        }
      });
    });
  });
</script>

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

                        <table data-page-length='50' id="file_datatable" class="table table-bordered">
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
                                                        <select class="form-select" id="category">
                                                            <option value="Choose" selected>Choose...</option>
                                                            @foreach ($categories as $category)
                                                            <option value="{{ $category->category }}" >{{ $category->category }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label  class="form-label">Service</label>
                                                        <select class="form-select" id="service">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div>
                                                    <div class="mb-3">
                                                        <label  class="form-label">Tax ID</label>
                                                        <input type="text" id="taxid" class="form-control
                                                            placeholder="Tax ID" value="Mark">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div>
                                                    <div class="mb-3">
                                                        <label  class="form-label">Customer Type</label>
                                                        <input type="text" id="customer_type" class="form-control
                                                            placeholder="Customer Type" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label  class="form-label">First name</label>
                                                        <input type="text" id="first_name" class="form-control
                                                            placeholder="First name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Last name</label>
                                                        <input type="text" id="last_name" class="form-control"
                                                            placeholder="Last name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label  class="form-label">Date of birth</label>
                                                        <input type="date" id="date_of_birth" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Telephone</label>
                                                        <input type="text" id="telephone" class="form-control"
                                                            placeholder="Telephone">
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

