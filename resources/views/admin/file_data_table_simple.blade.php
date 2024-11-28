@extends('admin.admin_master')
@section('admin')

<meta name="csrf-token" content="{{ csrf_token() }}" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
$(document).ready(function() {
    // Sorting functionality for each column

    $('#file_datatable thead th.sortable').on('click', function(e) {
        if ($(e.target).is('input, select, .fa-calendar-alt')) {
            return; // Prevent sorting when clicking inside the filter input or dropdown or calendar icon
        }
        const column = $(this).data('column');
        const order = $(this).hasClass('asc') ? 'desc' : 'asc';
        $('#file_datatable thead th').removeClass('asc desc');
        $(this).addClass(order);
        sortTable(column, order);
    });

    function sortTable(column, order) {
        const rows = $('#file_datatable tbody tr').get();
        rows.sort(function(a, b) {
            const A = $(a).children('td').eq(column).text().toUpperCase();
            const B = $(b).children('td').eq(column).text().toUpperCase();
            if (A < B) {
                return order === 'asc' ? -1 : 1;
            }
            if (A > B) {
                return order === 'asc' ? 1 : -1;
            }
            return 0;
        });
        $.each(rows, function(index, row) {
            $('#file_datatable tbody').append(row);
        });
    }

    // Dropdown filter for Shop, Service, and Status columns
    $('.filter-dropdown').on('change', function() {
        filterTable();
        highlightFilterIcon($(this).closest('th'));
    });

    // Input filter for File ID, Tax ID, and Customer columns
    $('.filter-input').on('keyup', function() {
        filterTable();
        highlightFilterIcon($(this).closest('th'));
    });

    function filterTable() {
        const shop = $('#filter_shop').val().toUpperCase();
        const service = $('#filter_service').val().toUpperCase();
        const status = $('#filter_status').val().toUpperCase();
        const fileId = $('#filter_file_id').val().toUpperCase();
        const taxId = $('#filter_tax_id').val().toUpperCase();
        const customer = $('#filter_customer').val().toUpperCase();

        $('#file_datatable tbody tr').each(function() {
            const rowShop = $(this).find('td:nth-child(4)').text().toUpperCase();
            const rowService = $(this).find('td:nth-child(5)').text().toUpperCase();
            const rowStatus = $(this).find('td:nth-child(8)').text().toUpperCase();
            const rowFileId = $(this).find('td:nth-child(1)').text().toUpperCase();
            const rowTaxId = $(this).find('td:nth-child(2)').text().toUpperCase();
            const rowCustomer = $(this).find('td:nth-child(3)').text().toUpperCase();

            if ((shop === '' || rowShop === shop) &&
                (service === '' || rowService === service) &&
                (status === '' || rowStatus === status) &&
                (fileId === '' || rowFileId.indexOf(fileId) > -1) &&
                (taxId === '' || rowTaxId.indexOf(taxId) > -1) &&
                (customer === '' || rowCustomer.indexOf(customer) > -1)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Highlight filter icon when filter is applied
    function highlightFilterIcon(thElement) {
        const input = thElement.find('.filter-input').val();
        const dropdown = thElement.find('.filter-dropdown').val();
        if (input !== '' || dropdown !== '') {
            thElement.find('.filter-icon').addClass('highlighted');
        } else {
            thElement.find('.filter-icon').removeClass('highlighted');
        }
    }

    // Toggle filter input visibility on filter icon click
    $('.filter-icon').on('click', function(e) {
        e.stopPropagation();
        const filterContainer = $(this).siblings('.filter-container');
        filterContainer.toggle();
    });

    // Add date range picker to the calendar icon click event
    $('#daterange-popup').on('click', function() {
        $('#daterange-popup').daterangepicker({
            opens: 'center',
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        }, function(start, end) {
            filterByDateRange(start, end);
        });
        $('#daterange-popup').data('daterangepicker').show();
    });

    function filterByDateRange(start, end) {
        $('#file_datatable tbody tr').each(function() {
            const rowDate = moment($(this).find('td:nth-child(6)').text(), 'YYYY-MM-DD');
            if (rowDate.isBetween(start, end, null, '[]')) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Clear filter button functionality
    $('#clear-filters-button').on('click', function() {
        $('.filter-input').val('');
        $('.filter-dropdown').prop('selectedIndex', 0);
        $('.filter-icon').removeClass('highlighted');
        filterTable();
    });
});
</script>

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
                    <div class='row'>
                        <div class='col' align="left">
                            <a href="" class="btn btn-secondary waves-effect waves-light" id='btn_clear_filters'>Clear Filters</a>
                        </div>
                        <div class='col' align="right">
                            <a href="" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="{{ $modealName }}">New</a>
                        </div>
                    </div>
                </p>

                <table data-page-length='50' id="file_datatable" class="table table-bordered file_datatable">
                    <thead>
                        <tr>
                            <th class="sortable filterable" data-column="1">
                                <strong>File ID</strong>
                                <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                                <i class="fas fa-sort sort-icon"></i>
                                <div class="filter-container" style="display: none;">
                                    <input type="text" id="search_file_id" class="form-control filter-input" placeholder="File ID">
                                </div>
                            </th>
                            <th class="sortable filterable" data-column="1">
                                <strong>Tax ID</strong>
                                <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                                <i class="fas fa-sort sort-icon"></i>
                                <div class="filter-container" style="display: none;">
                                    <input type="text" id="search_tax_id" class="form-control filter-input" placeholder="Search by Tax ID">
                                </div>
                            </th>
                            <th style="width:2%"></th>
                            <th class="sortable filterable" data-column="1">
                                <strong>Customer</strong>
                                <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                                <i class="fas fa-sort sort-icon"></i>
                                <div class="filter-container" style="display: none;">
                                    <input type="text" id="search_customer_name" class="form-control filter-input" placeholder="Search by Customer Name">
                                </div>
                            </th>
                            <th class="filterable">
                                <strong>Shop</strong>
                                <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                                <div class="filter-container" style="display: none;">
                                    <select id="filter_shop_name" class="form-control filter-dropdown">
                                        <option value="">All Shops</option>
                                        @foreach($shops as $shop)
                                            @if($shop->shop_name != "")
                                            <option value="{{ $shop->shop_name }}">{{ $shop->shop_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </th>
                            <th class="filterable">
                                <strong>Service</strong>
                                <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                                <div class="filter-container" style="display: none;">
                                    <select id="filter_service_type" class="form-control filter-dropdown">
                                        <option value="">All Services</option>
                                        @foreach($services as $service)
                                            @if($service->service != "")
                                            <option value="{{ $service->service }}">{{ $service->service }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </th>
                            <div id="modal_daterange" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mySmallModalLabel">Add Filter</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-form-label">Start Date</label>
                                                <div>
                                                    <input class="form-control" type="date" value="<?= date('Y-m-d') ?>" id="start_date_modal" name="start_date_modal">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-form-label">End Date</label>
                                                <div>
                                                    <input class="form-control" type="date" value="<?= date('Y-m-d') ?>" id="end_date_modal" name="end_date_modal">
                                                </div>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-outline-primary waves-effect waves-light" id="apply_daterange">Apply</button>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <th class="filterable" data-column="1">
                                <strong>Created</strong>
                                <i class="fas fa-calendar calendar-icon" data-bs-toggle="modal" data-bs-target=".bs-example-modal-sm"></i>
                                    <input type="text" id="daterange-popup" style="display: none;" />
                                </div>
                            </th>
                            <input class="form-control" type="date" value="" id="start_date" name="start_date" hidden>
                            <input class="form-control" type="date" value="" id="end_date" name="end_date" hidden>
                            <th style="width:2%"></th>
                            <th class="filterable">
                                <strong>Status</strong>
                                <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                                <div class="filter-container" style="display: none;">
                                    <select id="filter_status" class="form-control filter-dropdown">
                                        <option value="">All Status</option>
                                        <option value="Submitted">Submitted</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </th>
                            <th style="width:3%">Actions</th>
                        </tr>
                    </thead>
                    <tbody id='tableBody'>
                        @foreach($data as $r)
                        <tr>
                            <td style="width:5%">{{ $r->file_id }}</td>
                            <td style="width:20%">{{ $r->taxid }}</td>
                            <td style="width:2%">
                                @if($r->is_subscribed == "1")
                                    <div><i class="ri-vip-crown-fill" style="color: #cf2847;"></i></div>
                                @endif
                            </td>
                            <td style="width:20%">{{ $r->customer }}</td>
                            <td style="width:18%">{{ $r->shop }}</td>
                            <td style="width:10%">{{ $r->service }}</td>
                            <td style="width:15%">{{ $r->created }}</td>

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
    var search_file_id = $('#search_file_id').val().toLowerCase();
    var search_tax_id = $('#search_tax_id').val().toLowerCase();
    var search_customer_name = $('#search_customer_name').val().toLowerCase();
    var shopName = $('#filter_shop_name').val();
    var serviceType = $('#filter_service_type').val();
    var status = $('#filter_status').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    $.ajax({
        url: "{{ route('load.table.search') }}",
        type: "GET",
        data: { start_date: start_date, end_date: end_date, search_tax_id: search_tax_id, search_customer_name: search_customer_name, 
            search_file_id:search_file_id, shop_name : shopName, service_type : serviceType,
             status : status },
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
            if(item.is_subscribed == '1')
                var cell21 = $("<td style='width:2%'>").html("<div><i class='ri-vip-crown-fill' style='color: #cf2847;'></i></div>");
            else
                var cell21 = $("<td style='width:2%'>").text("");
            var cell3 = $("<td style='width:20%'>").text(item.customer);
            var cell4 = $("<td style='width:18%'>").text(item.shop);
            var cell5 = $("<td style='width:10%'>").text(item.service);
            var cell51 = $("<td style='width:15%'>").text(item.created);
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
            row.append(cell1, cell2, cell21, cell3, cell4, cell5, cell51, cell6, cell7, cell8);
            // Append the row to the table body
            $("#tableBody").append(row);
          });
        }
      });
    }


    $("#apply_daterange").on("click", function() {
        var start_date_val = $('#start_date_modal').val();
        var end_date_val = $('#end_date_modal').val();
        $('#start_date').val(start_date_val);
        $('#end_date').val(end_date_val);
        $('#modal_daterange').modal('toggle');
        searchAndFilter();
    });

    $("#search-box").on("keyup", function() {
        searchAndFilter();
    });

    $("#search_file_id").on("keyup", function() {
        searchAndFilter();
    });
    $("#search_tax_id").on("keyup", function() {
        searchAndFilter();
    });
    $("#search_customer_name").on("keyup", function() {
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
    $("#filter_shop_name").on("change", function() {
        searchAndFilter();
    });
    $("#filter_service_type").on("change", function() {
        searchAndFilter();
    });
    $("#filter_status").on("change", function() {
        searchAndFilter();
    });

    document.getElementById("btn_clear_filters").addEventListener("click", function(event) {
    event.preventDefault();
    window.location.href = '/file/data/simple/admin';
    });

</script>
@endsection

