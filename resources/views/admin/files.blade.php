<!-- Including AlpineJS for dropdown and sorting functionalities -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Adding table column sorting and filter dropdowns -->
@extends('admin.admin_master')
@section('admin')

<meta name="csrf-token" content="{{ csrf_token() }}" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
    $('#calendar-icon').on('click', function() {
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


<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="card-title">File Informations</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Files</li>
                </ol>
            </div>
        </div>
        <h2>Files</h2>

        <button id="clear-filters-button" class="btn btn-secondary mb-3">Clear Filters</button>

        <table data-page-length='50' id="file_datatable" class="table table-bordered file_datatable">
            <thead>
                <tr>
                    <th class="sortable filterable" data-column="0">
                        <strong>File ID</strong>
                        <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                        <i class="fas fa-sort sort-icon"></i>
                        <div class="filter-container" style="display: none;">
                            <input type="text" id="filter_file_id" class="form-control filter-input" placeholder="Filter by File ID">
                        </div>
                    </th>
                    <th class="sortable filterable" data-column="1">
                        <strong>Tax ID</strong>
                        <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                        <i class="fas fa-sort sort-icon"></i>
                        <div class="filter-container" style="display: none;">
                            <input type="text" id="filter_tax_id" class="form-control filter-input" placeholder="Filter by Tax ID">
                        </div>
                    </th>
                    <th class="sortable filterable" data-column="2">
                        <strong>Customer</strong>
                        <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                        <i class="fas fa-sort sort-icon"></i>
                        <div class="filter-container" style="display: none;">
                            <input type="text" id="filter_customer" class="form-control filter-input" placeholder="Filter by Customer">
                        </div>
                    </th>
                    <th class="sortable filterable" data-column="3">
                        <strong>Shop</strong>
                        <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                        <i class="fas fa-sort sort-icon"></i>
                        <div class="filter-container" style="display: none;">
                            <select id="filter_shop" class="form-control filter-dropdown">
                                <option value="">All Shops</option>
                                @foreach($shops as $shop)
                                    <option value="{{ $shop->shop_name }}">{{ $shop->shop_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </th>
                    <th class="sortable filterable" data-column="4">
                        <strong>Service</strong>
                        <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                        <i class="fas fa-sort sort-icon"></i>
                        <div class="filter-container" style="display: none;">
                            <select id="filter_service" class="form-control filter-dropdown">
                                <option value="">All Services</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->service }}">{{ $service->service }}</option>
                                @endforeach
                            </select>
                        </div>
                    </th>
                    <th class="sortable" data-column="5">
                        <strong>Created</strong>
                        <i class="fas fa-sort sort-icon"></i>
                        <i id="calendar-icon" class="fas fa-calendar-alt" style="cursor: pointer; margin-left: 5px;"></i>
                        <input type="text" id="daterange-popup" style="display: none;" />
                    </th>
                    <th class="filterable">
                        <strong>Status</strong>
                        <i class="fas fa-filter filter-icon" style="cursor: pointer;"></i>
                        <div class="filter-container" style="display: none;">
                            <select id="filter_status" class="form-control filter-dropdown">
                                <option value="">All Status</option>
                                <option value="submitted">Submitted</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </th>
                    <th class="sortable" data-column="6">
                        <strong>Actions</strong>
                        <i class="fas fa-sort sort-icon"></i>
                    </th>
                </tr>
            </thead>
            <tbody id='tableBody'>
                @foreach($data as $r)
                <tr>
                    <td>{{ $r->file_id }}</td>
                    <td>{{ $r->taxid }}</td>
                    <td>{{ $r->customer }}</td>
                    <td>{{ $r->shop }}</td>
                    <td>{{ $r->service }}</td>
                    <td>{{ $r->created }}</td>
                    <td>{{ $r->status }}</td>
                    <td>
                        <a class="btn btn-outline-success btn-sm edit" href="{{ route('file.show',$r->file_id) }}" target="_blank" title="Show">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a class="btn btn-outline-danger btn-sm edit" href="{{ route('file.delete',$r->file_id) }}" target="_blank" title="Delete">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div id="pagination" class="d-flex justify-content-center">
            {!! $data->links() !!}
        </div>
    </div>
</div>
@endsection