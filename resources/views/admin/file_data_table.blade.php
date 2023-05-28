@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  $(document).ready(function() {
    $('#category').change(function() {
      var value = $(this).val();
      if(value.toLowerCase() === 'pagamento'){
        $('#div_description').show();
        $('#div_pay_amount').show();
        $('#div_service').hide();
      }else{
        $('#div_description').hide();
        $('#div_pay_amount').hide();
        $('#div_service').show();
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
    }
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

<script>
  $(document).ready(function() {
    $('#submit-admin').click(function() {
      // Get data from Modal 1
      var data1 = $('#form1').serialize();

      // Get data from Modal 2
      var data2 = $('#form2').serialize();

      // Combine data from both modals
      var data = data1 + '&' + data2;
     

      // Submit the data
      $.ajax({
        url: '{{ route('file.store') }}',
        method: 'POST',
        data: data,
        success: function(response) {
          // Handle the response
          if(response.status == 'success'){
            $('.file_datatable').load(location.href+' .table');
          }
        }
      });
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#submit-user').click(function() {
      // Get data from Modal 2
      var data = $('#form2').serialize();
      // Submit the data
      $.ajax({
        url: '{{ route('file.store') }}',
        method: 'POST',
        data: data,
        success: function(response) {
          // Handle the response
          if(response.status == 'success'){
            $('.file_datatable').load(location.href+' .table');
          }
        }
      });
    });
  });
</script>

<script type="text/javascript">
    $(function () {
        var view_type = $('#view_type').val();
        var table = $('.file_datatable').DataTable({
            processing: true,
            serverSide: false,
            order: [[0, 'desc']],
            columnDefs: [
                    { width: "150px", targets: 0 },
                    { width: "150px", targets: 1 },
                    { width: "150px", targets: 2 },
                    { width: "200px", targets: 3 },
                    { width: "200px", targets: 4 },
                    { width: "0px", targets: 5 },
                    { width: "100px", targets: 6 },
                    { width: "100px", targets: 7 }
            ],
            autoWidth: false,
            ajax: "{{ route('file.data' , 'all') }}",
            columns: [
                {data: 'file_id', name: 'file_id'},
                {data: 'taxid', name: 'taxid'},
                {data: 'customer', name: 'customer'},
                {data: 'shop', name: 'shop'},
                {data: 'service', name: 'service'},
                {data: 'icon', name: 'icon'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            initComplete: function () {
            serverSide: true,
            this.api()
                .columns([3,4])
                .every(function () {
                    var column = this;
                    var select = $('<br><select style="width:200px"><option value=""></option></select>')
                        .appendTo($(column.header()))
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
 
                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append('<option>' + d + '</option>');
                        });
                });
            this.api()
                .columns([6])
                .every(function () {
                    var column = this;
                    var select = $('<br><select style="width:100px"><option value=""></option></select>')
                        .appendTo($(column.header()))
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
 
                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append('<option>' + d + '</option>');
                        });
                });
            this.api()
                .columns([0,1,2])
                .every(function () {
                    var column = this;
                    $('<br><input style="width:150px" type="text" placeholder="Search" />')
                    .appendTo($(column.header()))
                    .on('keyup change clear', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                });
            },
        });
    });
</script>

<script>
  $(document).ready(function() {
    $("#view_all a").click(function() {
        alert('hi');
      $('#view_type').val('all');
      
    });
  });
</script>

@php
    $user_type = Auth::user()->user_type;
    if($user_type == 'admin' || $user_type == 'lawyer') $modealName = "#firstmodal";
    else $modealName = "#myModal";
@endphp

<div class="page-content">
    <div class="container-fluid">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">File Informations @if($user_type == 'admin')<sub><a href="{{ route('file.data', 'all')}}" id="view_all"> View All </a></sub>@endif</h4>
                    <input type="hidden" id="view_type" value="all">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('file.data', 'user')}}">Files</a></li>
                        </ol>
                    </div>
                </div>
                <p class="card-title-desc" >
                    <div align="right">
                        <a href="" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="{{ $modealName }}">New</a>
                    </div>
                </p>
                <table data-page-length='50' id="file_datatable" class="table table-bordered file_datatable">
                    <thead>
                        <tr>
                            <th>File ID</th>
                            <th>Tax ID</th>
                            <th>Customer</th>
                            <th>Shop</th>
                            <th>Service</th>
                            <th></th>
                            <th>Status</th>
                            <th style="width:150px">Actions</th>
                        </tr>
                    </thead>
                
                    <tbody></tbody>
                </table>

                @php
                    $categories = App\Models\Category::all();
                    $users = App\Models\User::all();
                @endphp

                <!-- sample modal content -->
                <div class="modal fade" id="firstmodal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Select User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" id="form1">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="formCheck1" checked>
                                                <label class="form-check-label" for="formCheck1">
                                                    Current User
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="mb-3">
                                                <label  class="form-label">Select User</label>
                                                <select class="form-select" id="user" name="user" disabled>
                                                    <option value="Choose" selected>Choose...</option>
                                                    @foreach ($users as $user)
                                                    <option value="{{ $user->username }}" >{{ $user->username }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="modal-footer">
                                <!-- Toogle to second dialog -->
                                <button class="btn btn-primary" data-bs-target="#myModal" data-bs-toggle="modal" data-bs-dismiss="modal">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">New File</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" id="form2">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label  class="form-label">Service Category</label>
                                                <select class="form-select" id="category" name="category">
                                                    <option value="Choose" selected>Choose...</option>
                                                    @foreach ($categories as $category)
                                                    @if(!(strtolower($category->category) == 'pagamento' && !($user_type == 'admin' || $user_type == 'lawyer')))
                                                    <option value="{{ $category->category }}" >{{ $category->category }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id='div_service'>
                                            <div class="mb-3">
                                                <label  class="form-label">Service</label>
                                                <select class="form-select" id="service" name="service">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id='div_pay_amount'>
                                            <div class="mb-3">
                                                <label  class="form-label">Pay Amount</label>
                                                <input class="form-select" type="number" id="pay_amount" name="pay_amount" 
                                                    placeholder="Amount">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="div_description">
                                        <div>
                                            <div class="mb-3">
                                                <label  class="form-label">Description</label>
                                                <textarea type="text" id="description" class="form-control"
                                                    placeholder="Descriptioin" name="description">
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="mb-3">
                                                <label  class="form-label">Tax ID</label>
                                                <input type="text" id="taxid" class="form-control"
                                                    placeholder="Tax ID" name="taxid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="mb-3">
                                                <label  class="form-label">Customer Type</label>
                                                <input type="text" id="customer_type" class="form-control"
                                                    placeholder="Customer Type"  name="customertype">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label  class="form-label">First name</label>
                                                <input type="text" id="first_name" class="form-control"
                                                    placeholder="First name" name="firstname">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Last name</label>
                                                <input type="text" id="last_name" class="form-control"
                                                    placeholder="Last name" name="lastname">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label  class="form-label">Date of birth</label>
                                                <input type="date" id="date_of_birth" class="form-control" name="dateofbirth">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Telephone</label>
                                                <input type="text" id="telephone" class="form-control"
                                                    placeholder="Telephone" name="telephone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancel</button>
                                    @if($user_type != 'user')
                                    <button id="submit-admin" type="submit" class="btn btn-primary waves-effect waves-light">Create</button>
                                    @else
                                    <button id="submit-user" type="submit" class="btn btn-primary waves-effect waves-light">Create</button>
                                    @endif
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div><!-- end col-->
</div>
<script>
    $(".modal").on("hidden.bs.modal", function(){
        $(".modal-body").html("");
    });
    document.getElementById('formCheck1').onchange = function() {
    document.getElementById('user').disabled = this.checked;
};
</script>

<script>
    document.getElementById('div_description').style.display = "none";
    document.getElementById('div_pay_amount').style.display = "none";
</script>
@endsection

