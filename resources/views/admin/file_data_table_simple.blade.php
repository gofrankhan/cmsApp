@extends('admin.admin_master')
@section('admin')

<meta name="csrf-token" content="{{ csrf_token() }}" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
  $('#show_filter_list').change(function() {
    var filterType = $('#select_filter_type').val();
    var selectedValue = $(this).val();
    $('#file_datatable tbody tr').each(function() {
      if(filterType === "shop")
        var rowValue = $(this).find('td:nth-child(4)').text(); //index 4 is for shop)
      if(filterType === "service")
        var rowValue = $(this).find('td:nth-child(5)').text(); //index 5 is for service)
      if(filterType === "status")
        var rowValue = $(this).find('td:nth-child(7)').text(); //index 7 is for shop)
      if (selectedValue === '' || rowValue === selectedValue) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });
});
</script>

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
        //   if(response.status == 'success'){
        //     $('.file_datatable').load(location.href+' .table');
        //   }
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
        //   if(response.status == 'success'){
        //     $('.file_datatable').load(location.href+' .table');
        //   }
        }
      });
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

<!-- AJAX script -->
<script>
    $(document).ready(function() {
        // Listen for click events on the delete icon/button
        $('#file_datatable').on('click', '.btn.btn-danger.btn-sm.edit', function(e) {
            e.preventDefault();
            var result = confirm("Want to delete?");
            if (result) {
                //Logic to delete the item
                var currentRow=$(this).closest("tr");
                var file_id=currentRow.find("td:eq(0)").text();
                // Send an AJAX request to delete the row
                $.ajax({
                    url: '/file/delete/simple/' + file_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Row deleted successfully, remove it from the table
                        currentRow.remove();
                        //$('#file_datatable').find('td[data-id="' + itemId + '"]').remove();
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error(xhr.responseText);
                    }
                });
            }
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
                    <h4 class="card-title">File Informations @if($user_type == 'admin')<sub><a href="{{ route('file.data.simple', 'all')}}" id="view_all"> View All </a></sub>@endif</h4>
                    <input type="hidden" id="view_type" value="all">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('file.data.simple', 'user')}}">Files</a></li>
                        </ol>
                    </div>
                </div>
                <p class="card-title-desc" >
                    <div align="right">
                        <a href="" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="{{ $modealName }}">New</a>
                    </div>
                </p>
                <form action="" id="formFilter">
                    @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <form class="app-search d-none d-lg-block" data-backdrop="static" data-keyboard="false" onsubmit="submitForm(event)">
                                <div class="position-relative">
                                    <input name="search-box" id="search-box" type="text" class="form-control" placeholder="Search...">
                                </div>
                            </form>
                        </div>
                        <div style="padding:15px" class="col-md-2">
                            
                        </div>
                        <div style="padding:15px" class="col-md-2">
                            <select style="width:200px" id="select_shop_name">
                                <option value="" selected>---Select Shop Name---</option>
                                @foreach($shops as $shop)
                                    @if($shop->shop_name != "")
                                    <option value="{{ $shop->shop_name }}">{{ $shop->shop_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div style="padding:15px" class="col-md-2">
                            <select style="width:200px" id="select_service_type">
                                <option value="" selected>---Select Service Type---</option>
                                @foreach($services as $service)
                                    @if($service->service != "")
                                    <option value="{{ $service->service }}">{{ $service->service }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div style="padding:15px" class="col-md-2">
                            <select style="width:200px" id="select_status">
                                <option value="" selected>---Select Status---</option>
                                <option value="submitted">Submitted</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </form>

                <table data-page-length='50' id="file_datatable" class="table table-bordered file_datatable">
                    <thead>
                        <tr>
                            <th style="width:5%">File ID</th>
                            <th style="width:20%">Tax ID</th>
                            <th style="width:20%">Customer</th>
                            <th style="width:20%">Shop</th>
                            <th style="width:25%">Service</th>
                            <th style="width:2%"></th>
                            <th style="width:5%">Status</th>
                            <th style="width:3%">Actions</th>
                        </tr>
                    </thead>
                    <tbody id='tableBody'>
                        @foreach($data as $r)
                        <tr>
                            <td style="width:5%">{{ $r->file_id }}</td>
                            <td style="width:20%">{{ $r->taxid }}</td>
                            <td style="width:20%">{{ $r->customer }}</td>
                            <td style="width:20%">{{ $r->shop }}</td>
                            <td style="width:25%">{{ $r->service }}</td>
                            <td style="width:2%">
                                @if($r->status == "Completed")
                                    <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2"></i></div>
                                @elseif($r->status == "Pending") 
                                    <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-warning align-middle me-2"></i></div>
                                @elseif($r->status == "Submitted")
                                    <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-dark align-middle me-2"></i></div>
                                @elseif($r->status == "Cancelled")
                                    <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-danger align-middle me-2"></i></div>
                                @endif
                            </td>
                            <td style="width:5%">{{ $r->status }}</td>
                            <td style="width:3%">
                                @if($user_type == 'admin')
                                    <div style="width:150px" class="row">
                                        <form action="{{ route('customer.delete',$r->id) }}" method="post">
                                            <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('file.show',$r->file_id) }}" target="_blank" title="Show">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('file.edit',$r->file_id) }}" target="_blank" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a type="submit" class="btn btn-danger btn-sm edit" href="{{ route('file.delete' ,$r->file_id) }}" title="Delete">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </form>
                                    </div>
                                @else
                                    @if($r->status == 'Completed' || $r->status == 'Cancelled' || $user_type == 'lawyer' )
                                        <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('file.show',$r->file_id) }}" target="_blank" title="Show">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @else
                                        <div style="width:150px" class="row">
                                            <div class="col-sm-3">
                                                <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('file.show',$r->file_id) }}" target="_blank" title="Show">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                            <div class="col-sm-3">
                                                <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('file.edit',$r->file_id) }}" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                Showing {{($data->currentPage()-1)* $data->perPage()+($data->total() ? 1:0)}} to {{($data->currentPage()-1)*$data->perPage()+count($data)}}  of  {{$data->total()}}  Results
                <div id="pagination" class="d-flex justify-content-center">
                    {!! $data->links() !!}
                </div>
                
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

<script>
    function searchAndFilter(){
    var searchText = $('#search-box').val().toLowerCase();
    var shopName = $('#select_shop_name').val();
    var serviceType = $('#select_service_type').val();
    var status = $('#select_status').val();
    $.ajax({
        url: "{{ route('load.table.search') }}",
        type: "GET",
        data: { search_text: searchText, shop_name : shopName, service_type : serviceType, status : status },
        success: function(data) {
           var user_type = (data[data.length - 1]);
          $("#tableBody").empty();
          // Loop through the response and add new rows to the table
          $.each(data[0], function(index, item) {
            var row = $("<tr>");
            // Create table cells and populate them with data
            var correntFileID = item.file_id;
            var cell1 = $("<td style='width:5%'>").text(correntFileID);
            var cell2 = $("<td style='width:20%'>").text(item.taxid);
            var cell3 = $("<td style='width:15%'>").text(item.customer);
            var cell4 = $("<td style='width:15%'>").text(item.shop);
            var cell5 = $("<td style='width:20%'>").text(item.service);
            if(item.status == "Completed")
                var cell6 = $("<td style='width:2%'>").html("<div class='font-size-13'><i class='ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2'></i></div>");
            if(item.status == "Pending")
                var cell6 = $("<td style='width:2%'>").html("<div class='font-size-13'><i class='ri-checkbox-blank-circle-fill font-size-10 text-warning align-middle me-2'></i></div>");
            if(item.status == "Submitted")
                var cell6 = $("<td style='width:2%'>").html("<div class='font-size-13'><i class='ri-checkbox-blank-circle-fill font-size-10 text-dark align-middle me-2'></i></div>");
            if(item.status == "Cancelled")
                var cell6 = $("<td style='width:2%'>").html("<div class='font-size-13'><i class='ri-checkbox-blank-circle-fill font-size-10 text-danger align-middle me-2'></i></div>");
            var cell7 = $("<td style='width:5%'>").text(item.status);
            var htmlContentAdmin = 
                '<div style="width:100px" class="row">'+
                    '<div class="col-md-4">'+
                        '<a class="btn btn-outline-secondary btn-sm edit" href="/file/show/' +item.file_id+ '" target="_blank" title="Show">'+
                            "<i class='fas fa-eye'></i>"+
                        "</a>"+
                    "</div>"+
                    '<div class="col-md-4">'+
                        '<a class="btn btn-outline-secondary btn-sm" href="/file/edit/' +item.file_id+ '" target="_blank" title="Show">'+
                            "<i class='fas fa-pencil-alt'></i>"+
                        "</a>"+
                    "</div>"+
                    '<div class="col-md-4">'+
                        "<a class='btn btn-danger btn-sm edit' target='_blank' title='Show'>"+
                            "<i class='fas fa-trash'></i>"+
                        "</a>"+
                    "</div>"+
                "</div>";
            var htmlContentUser = 
                '<div style="width:100px" class="row">'+
                    '<div class="col-md-4">'+
                        '<a class="btn btn-outline-secondary btn-sm edit" href="/file/show/' +item.file_id+ '" target="_blank" title="Show">'+
                            "<i class='fas fa-eye'></i>"+
                        "</a>"+
                    "</div>"+
                    '<div class="col-md-4">'+
                        '<a class="btn btn-outline-secondary btn-sm" href="/file/edit/' +item.file_id+ '" target="_blank" title="Show">'+
                            "<i class='fas fa-pencil-alt'></i>"+
                        "</a>"+
                    "</div>"+
                "</div>";
            var htmlContentViewOnly = 
                '<div style="width:100px" class="row">'+
                    '<div class="col-md-4">'+
                        '<a class="btn btn-outline-secondary btn-sm edit" href="/file/show/' +item.file_id+ '" target="_blank" title="Show">'+
                            "<i class='fas fa-eye'></i>"+
                        "</a>"+
                    "</div>"+
                "</div>";
            if(user_type == "admin")
                var cell8 = $("<td style='width:3%'>").html(htmlContentAdmin);
            else{
                if(item.status == "Completed" || item.status == "Cancelled" || user_type == "lawyer"){
                    var cell8 = $("<td style='width:3%'>").html(htmlContentViewOnly);
                }else{
                    var cell8 = $("<td style='width:3%'>").html(htmlContentUser);
                }
            }
                
            // Add more cells as needed

            // Append the cells to the row
            row.append(cell1, cell2, cell3, cell4, cell5, cell6, cell7, cell8);
            // Append the row to the table body
            $("#tableBody").append(row);
          });
        }
      });
    }


    $("#search-box").on("keyup", function() {
        searchAndFilter();
    });
    $("#select_shop_name").on("change", function() {
        searchAndFilter();
    });
    $("#select_service_type").on("change", function() {
        searchAndFilter();
    });
    $("#select_status").on("change", function() {
        searchAndFilter();
    });

</script>
@endsection

