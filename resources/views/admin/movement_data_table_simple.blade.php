@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@php
    $user_type = Auth::user()->user_type;
@endphp
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="card-title">Movement Informations @if($user_type == 'admin')<sub><a href="{{ route('movement.data.all.simple')}}">View All </a></sub>@endif</h4>
            @if(isset($total_sum))
            @if($total_sum < 0)
            <h3 class="card-title">Current Balance: {{ -$total_sum }}</h3>
            @else
            <h3 class="card-title">Payable Amount: {{ $total_sum }}</h3>
            @endif
            @endif
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('movement.data.simple')}}">Movement</a></li>
                </ol>
            </div>
        </div>
        <div style="padding:15px" class="col-md-2">
            <select style="width:200px" id="select_service_type">
                <option value="" selected>---Filter Service Type---</option>
                @foreach($services as $service)
                    @if($service->service != "")
                    <option value="{{ $service->service }}">{{ $service->service }}</option>
                    @endif
                @endforeach
            </select>
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
        <p class="card-title-desc" >
            <div align="right">
                <a href="" hidden class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=""></a>
            </div>
        </p>
        <table id="movement_datatable_simple" class="table table-bordered movement_datatablel_simple">
            <thead>
                <tr>
                    <th style="width:10%">ID</th>
                    <th style="width:25%">Customer Name</th>
                    <th style="width:25%">Service Name</th>
                    <th style="width:25%">Description</th>
                    <th style="width:25%">Shop Name</th>
                    <th></th>
                    <th style="width:15%">Amount</th>
                </tr>
            </thead>
        
            <tbody>
                @foreach($data as $r)
                <tr>
                    <td style="width:10%">{{$r->file_id}}</td>
                    <td style="width:20%">{{$r->customer}}</td>
                    <td style="width:20%">{{$r->service}}</td>
                    <td style="width:20%">{{$r->description}}</td>
                    <td style="width:20%">{{$r->shop}}</td>
                    <td></td>
                    <td style="width:15% text-align:left" >{{$r->amount}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div id="pagination" class="d-flex justify-content-center">
            {!! $data->links() !!}
        </div>
    </div><!-- end col-->
</div>


<script>

    function FilterServiceType(){

        var serviceType = $('#select_service_type').val();
        $.ajax({
            url: "{{ route('movement.filter.service') }}",
            type: "GET",
            data: { service_type : serviceType, all_data : false },
            success: function(data) {
            $("#tableBody").empty();
            // Loop through the response and add new rows to the table
                $.each(data, function(index, item) {
                    var row = $("<tr>");
                    // Create table cells and populate them with data
                    var cell1 = $("<td style='width:10%'>").text(item.file_id);
                    var cell2 = $("<td style='width:20%'>").text(item.customer);
                    var cell3 = $("<td style='width:20%'>").text(item.service);
                    var cell4 = $("<td style='width:20%'>").text(item.description);
                    var cell4 = $("<td style='width:20%'>").text(item.shop);
                    var cell5 = $("<td style='width:15%'>").text(item.amount);
                    
                        
                    // Add more cells as needed

                    // Append the cells to the row
                    row.append(cell1, cell2, cell3, cell4, cell5);
                    // Append the row to the table body
                    $("#tableBody").append(row);
                });
            }
        });
    }

    $("#select_service_type").on("change", function() {
        FilterServiceType();
    });
</script>

@endsection

