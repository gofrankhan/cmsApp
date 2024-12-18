@extends('admin.admin_master')
@section('admin')

<script>
$(document).ready(function() {
    // Sorting functionality for each column

    $('#movement_datatable_all_simple thead th.sortable').on('click', function(e) {
        if ($(e.target).is('input, select, .fa-calendar-alt')) {
            return; // Prevent sorting when clicking inside the filter input or dropdown or calendar icon
        }
        const column = $(this).data('column');
        const order = $(this).hasClass('asc') ? 'desc' : 'asc';
        $('#movement_datatable_all_simple thead th').removeClass('asc desc');
        $(this).addClass(order);
        sortTable(column, order);
    });

    function sortTable(column, order) {
        const rows = $('#movement_datatable_all_simple tbody tr').get();
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
            $('#movement_datatable_all_simple tbody').append(row);
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

    // Toggle search input visibility on filter icon click
    $('.search-icon').on('click', function(e) {
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@php
    $user_type = Auth::user()->user_type;
@endphp
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="card-title">Movement Informations</h4>
            @if(isset($total_sum))
            <h3 class="card-title">Payable Amount: {{ $total_sum }}</h3>
            @endif
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('movement.data.simple')}}">Movement</a></li>
                </ol>
            </div>
        </div>
        <p class="card-title-desc" >
            <div class='row'>
                <div class='col' align="left">
                    <a href="" class="btn btn-secondary waves-effect waves-light" id='btn_clear_filters'>Clear Filters</a>
                </div>
            </div>
        </p>
        <table data-page-length='50' id="movement_datatable_all_simple" class="table table-bordered movement_datatable_all_simple">
            <thead>
                <tr>
                    <th class="sortable filterable" data-column="1">
                        <strong>File ID</strong>
                        <i class="fas fa-search search-icon" style="cursor: pointer;"></i>
                        <i class="fas fa-sort sort-icon"></i>
                        <div class="filter-container" style="display: none;">
                            <input type="text" id="search_file_id" class="form-control filter-input" placeholder="Search ID">
                        </div>
                    </th>
                    <th class="sortable filterable" data-column="1">
                        <strong>Customer Name</strong>
                        <i class="fas fa-search search-icon" style="cursor: pointer;"></i>
                        <i class="fas fa-sort sort-icon"></i>
                        <div class="filter-container" style="display: none;">
                            <input type="text" id="search_name" class="form-control filter-input" placeholder="Search Name">
                        </div>
                    </th>
                    <th class="filterable">
                        <strong>Service</strong>
                        <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                        <i class="fas fa-sort sort-icon"></i>
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
                    <th style="width:20%">Description</th>
                    <th class="filterable">
                        <strong>Shop</strong>
                        <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                        <i class="fas fa-sort sort-icon"></i>
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
                    <th></th>
                    <th style="width:15%">Amount</th>
                </tr>
            </thead>
        
            <tbody id="tableBody">
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
        Showing {{($data->currentPage()-1)* $data->perPage()+($data->total() ? 1:0)}} to {{($data->currentPage()-1)*$data->perPage()+count($data)}}  of  {{$data->total()}}  Results
        <div id="pagination" class="d-flex justify-content-center">
            {!! $data->links() !!}
        </div>
    </div><!-- end col-->
</div>


<script>

    function FilterServiceType(){

        var serviceType = $('#filter_service_type').val();
        var shopName = $('#filter_shop_name').val();
        var file_id = $('#search_file_id').val();
        var customer_name = $('#search_name').val();
        $.ajax({
            url: "{{ route('movement.filter.service') }}",
            type: "GET",
            data: { service_type : serviceType, shop_name : shopName, file_id: file_id, customer_name: customer_name,  all_data : true },
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
                    var cell5 = $("<td style='width:20%'>").text(item.shop);
                    var cell6 = $("<td style='width:0%'>").text("");
                    var cell7 = $("<td style='width:15% text-align:left'>").text(item.amount);
                    
                        
                    // Add more cells as needed

                    // Append the cells to the row
                    row.append(cell1, cell2, cell3, cell4, cell5, cell6, cell7);
                    // Append the row to the table body
                    $("#tableBody").append(row);
                });
            }
        });
    }


    $("#filter_service_type").on("change", function() {
        FilterServiceType();
    });
    $("#filter_shop_name").on("change", function() {
        FilterServiceType();
    });
    $("#search_file_id").on("keyup", function() {
        FilterServiceType();
    });
    $("#search_name").on("keyup", function() {
        FilterServiceType();
    });

    document.getElementById("btn_clear_filters").addEventListener("click", function(event) {
        event.preventDefault();
        window.location.href = '/movement/data/all/simple';
    });
</script>

@endsection

