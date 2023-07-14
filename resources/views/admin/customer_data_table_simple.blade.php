@extends('admin.admin_master')
@section('admin')

<script>
    function submitForm(event) {
        event.preventDefault();
        var taxidOrNameOrMobile = $('#search-box').val();
        $('#search-box').attr('disabled', 'disabled');
        $.ajax({
        url: "{{ route('customer.search') }}",
        type: "GET",
        data: { taxidOrNameOrMobile : taxidOrNameOrMobile },
        success: function(data) {
          $('#btn_modal').click();
          $.each(data, function(index, item) {
            $("#modal_label").append($('<a>', {
                href: "/customer/show/" + item.id,
                text: item.taxid,
                target: "_blank"
            }));
            $("#modal_label").append("<br>");
          });
        }
      });
    }
    function clickCloseForm(event){
        $('#search-box').removeAttr('disabled');
        $('#search-box').val("");
        location.reload(true);
    }
</script>

@php
    $user_type = Auth::user()->user_type;
@endphp

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
                    <div class="row mb-3">
                        <div class="col-sm-5">
                            <form class="app-search d-none d-lg-block" data-backdrop="static" data-keyboard="false" onsubmit="submitForm(event)">
                                <div class="position-relative">
                                    <input name="search-box" id="search-box" type="text" class="form-control" placeholder="Search By Tax ID, Name or Mobile No.">
                                    <span class="ri-search-line"></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <form class="app-search d-none d-lg-block" data-backdrop="static" data-keyboard="false">
                                <div class="position-relative">
                                    <input name="search-box_any" id="search-box_any" type="text" class="form-control" placeholder="Search...">
                                    <span class="ri-search-line"></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3" align="right">
                        <button type="button" hidden id="btn_modal" data-bs-target="#listmodal" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-primary waves-effect waves-light">New</button>
                        </div>
                        <div class="col-sm-1" align="right">
                            <a href="{{ route('customer.new') }}" class="btn btn-primary waves-effect waves-light">New</a>
                        </div>
                    </div>
                </p>
            </div><!-- end col-->
        </div>
        <table data-page-length='50' id="customer_datatable" class="table table-bordered customer_datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Tax ID</th>
                    <th>Name</th>
                    <th>Mobile No</th>
                    <th></th>
                    <th>Actions</th>
                </tr>
            </thead>
        
            <tbody id='tableBody'>
                @foreach($data as $r)
                <tr>
                    <td style="width:5%">{{ $r->id }}</td>
                    <td style="width:20%">{{ $r->customertype }}</td>
                    <td style="width:20%">{{ $r->taxid }}</td>
                    <td style="width:20%">{{ $r->fullname }}</td>
                    <td style="width:25%">{{ $r->mobile }}</td>
                    <td style="width:0%"></td>
                    <td style="width:3%">
                        @if($user_type == 'admin')
                            <div style="width:100px" class="row">
                                <div class="col-md-4">
                                    <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('customer.show',$r->id) }}" target="_blank" title="Show">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a type="submit" class="btn btn-outline-secondary btn-sm edit" href="{{ route('customer.edit' ,$r->id) }}" title="Delete">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a type="submit" class="btn btn-danger btn-sm edit" href="{{ route('customer.delete' ,$r->id) }}" title="Delete">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        @else
                            <div style="width:100px" class="row">
                                <div class="col-md-4">
                                    <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('customer.show',$r->id) }}" target="_blank" title="Show">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('customer.edit',$r->id) }}" target="_blank" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- end row-->
        <div class="modal fade" id="listmodal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Search Result</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="form1">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div>
                                    <div id="modal_label" class="mb-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <!-- Toogle to second dialog -->
                        <button onclick="clickCloseForm(event)" class="btn btn-primary" data-bs-target="" data-bs-toggle="modal" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#search-box_any").on("keyup", function() {
    var searchText = $('#search-box_any').val().toLowerCase();
    
    $.ajax({
        
        url: "{{ route('load.customer.table.search') }}",
        type: "GET",
        data: { search_text: searchText},
        success: function(data) {
            $("#tableBody").empty();
            // Loop through the response and add new rows to the table
            $.each(data, function(index, item) {
            var row = $("<tr>");
            // Create table cells and populate them with data
            var cell1 = $("<td style='width:10%'>").text(item.id);
            var cell2 = $("<td style='width:20%'>").text(item.customertype);
            var cell3 = $("<td style='width:20%'>").text(item.taxid);
            var cell4 = $("<td style='width:25%'>").text(item.fullname);
            var cell5 = $("<td style='width:25%'>").text(item.mobile);
            // Add more cells as needed

            // Append the cells to the row
            row.append(cell1, cell2, cell3, cell4, cell5);
            // Append the row to the table body
            $("#tableBody").append(row);
          });
        }
        });
    });
});

</script>

@endsection

