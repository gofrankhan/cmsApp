@extends('admin.admin_master')
@section('admin')
    <script>
        $(document).ready(function() {
            // Sorting functionality for each column

            $('#customer_datatable_simple thead th.sortable').on('click', function(e) {
                if ($(e.target).is('input, select, .fa-calendar-alt')) {
                    return; // Prevent sorting when clicking inside the filter input or dropdown or calendar icon
                }

                const column = $(this).data('column');
                const order = $(this).hasClass('asc') ? 'desc' : 'asc';
                $('#customer_datatable_simple thead th').removeClass('asc desc');
                $(this).addClass(order);
                sortTable(column, order);
            });

            function sortTable(column, order) {

                const rows = $('#customer_datatable_simple tbody tr').get();
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
                    $('#customer_datatable_simple tbody').append(row);
                });
            }

            // Dropdown filter for Shop, Service, and Status columnst
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
                    thElement.find('.search-icon').addClass('highlighted');
                } else {
                    thElement.find('.search-icon').removeClass('highlighted');
                }
            }

            // Toggle filter input visibility on filter icon click
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

    <script>
        function submitForm(event) {
            event.preventDefault();
            var taxidOrNameOrMobile = $('#search-box').val();
            $('#search-box').attr('disabled', 'disabled');
            $.ajax({
                url: "{{ route('customer.search') }}",
                type: "GET",
                data: {
                    taxidOrNameOrMobile: taxidOrNameOrMobile
                },
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

        function clickCloseForm(event) {
            $('#search-box').removeAttr('disabled');
            $('#search-box').val("");
            location.reload(true);
        }
    </script>


    <!-- AJAX script -->
    <script>
        $(document).ready(function() {
            // Listen for click events on the delete icon/button
            $('#customer_datatable_simple').on('click', '.btn.btn-danger.btn-sm.edit', function(e) {
                e.preventDefault();
                var result = confirm("Want to delete?");
                if (result) {
                    //Logic to delete the item
                    var currentRow = $(this).closest("tr");
                    var _id = currentRow.find("td:eq(0)").text();
                    // Send an AJAX request to delete the row
                    $.ajax({
                        url: '/customer/delete/' + _id,
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
    @endphp

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Customer's Information</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active"><a
                                        href="{{ route('customer.data.simple') }}">Customers</a></li>
                            </ol>
                        </div>
                    </div>
                    <p class="card-title-desc">
                    <div hidden class="row">
                        <div hidden class="col-sm-4">
                            <form class="app-search d-none d-lg-block" data-backdrop="static" data-keyboard="false">
                                <div class="position-relative">
                                    <input name="search-box_any" id="search-box_any" type="text" class="form-control"
                                        placeholder="Search...">
                                    <span class="ri-search-line"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                    </p>
                </div><!-- end col-->
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class='col'>
                            <a href="" class="btn btn-secondary" id='btn_clear_filters'>Clear Filters</a>
                        </div>
                        <div class="col-sm-4">
                            <form class="app-search d-none d-lg-block" data-backdrop="static" data-keyboard="false"
                                onsubmit="submitForm(event)">
                                <div class="position-relative">
                                    <input name="search-box" id="search-box" type="text" class="form-control"
                                        placeholder="Search By Tax ID, Name or Mobile No.">
                                    <span class="ri-search-line"></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2" align="right">
                            <button type="button" hidden id="btn_modal" data-bs-target="#listmodal" data-bs-toggle="modal"
                                data-bs-dismiss="modal" class="btn btn-primary waves-effect waves-light">New</button>
                        </div>
                        <div class='col-sm-1' align="right">
                            <a href="{{ route('customer.new') }}" class="form-control btn btn-primary">New</a>
                        </div>
                        <div align="right" class="col-1">
                            <a href="{{ route('customer.export') }}"
                                class="form-control  btn btn-primary waves-effect waves-light">Export CSV</a>
                        </div>
                        <div align="right" class="col-1">
                            <a href="{{ route('customer.export.pdf') }}"
                                class="form-control  btn btn-primary waves-effect waves-light">Export PDF</a>
                        </div>
                    </div>
                </div>
            </div>
            <table data-page-length='50' id="customer_datatable_simple"
                class="table table-bordered customer_datatable_simple">
                <thead>
                    <tr>
                        <th class="sortable filterable" data-column="1">
                            <strong>ID</strong>
                            <i class="fas fa-search search-icon" style="cursor: pointer;"></i>
                            <i class="fas fa-sort sort-icon"></i>
                            <div class="filter-container" style="display: none;">
                                <input type="text" id="search_id" class="form-control filter-input"
                                    placeholder="Search ID">
                            </div>
                        </th>
                        <th>Type</th>
                        <th class="sortable filterable" data-column="1">
                            <strong>Tax ID</strong>
                            <i class="fas fa-search search-icon" style="cursor: pointer;"></i>
                            <i class="fas fa-sort sort-icon"></i>
                            <div class="filter-container" style="display: none;">
                                <input type="text" id="search_tax_id" class="form-control filter-input"
                                    placeholder="Search by Tax ID">
                            </div>
                        </th>
                        <th class="sortable filterable" data-column="1">
                            <strong>Name</strong>
                            <i class="fas fa-search search-icon" style="cursor: pointer;"></i>
                            <i class="fas fa-sort sort-icon"></i>
                            <div class="filter-container" style="display: none;">
                                <input type="text" id="search_name" class="form-control filter-input"
                                    placeholder="Search by Name">
                            </div>
                        </th>
                        <th class="sortable filterable" data-column="1">
                            <strong>Mobile No</strong>
                            <i class="fas fa-search search-icon" style="cursor: pointer;"></i>
                            <i class="fas fa-sort sort-icon"></i>
                            <div class="filter-container" style="display: none;">
                                <input type="text" id="search_mobile_no" class="form-control filter-input"
                                    placeholder="Search by Mobile No.">
                            </div>
                        </th>
                        <th style="width:0%"></th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id='tableBody'>
                    @foreach ($data as $r)
                        <tr>
                            <td style="width:10%">{{ $r->id }}</td>
                            <td style="width:20%">{{ $r->customertype }}</td>
                            <td style="width:20%">{{ $r->taxid }}</td>
                            <td style="width:20%">{{ $r->fullname }}</td>
                            <td style="width:20%">{{ $r->mobile }}</td>
                            <td style="width:0%"></td>
                            <td style="width:3%">
                                @if ($user_type == 'admin')
                                    <div style="width:100px" class="row">
                                        <div class="col-md-4">
                                            <a class="btn btn-outline-secondary btn-sm edit"
                                                href="{{ route('customer.show', $r->id) }}" target="_blank"
                                                title="Show">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a type="submit" class="btn btn-outline-secondary btn-sm edit"
                                                href="{{ route('customer.edit', $r->id) }}" title="Delete">
                                                <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a type="submit" class="btn btn-danger btn-sm edit"
                                                href="{{ route('customer.delete', $r->id) }}" title="Delete">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div style="width:100px" class="row">
                                        <div class="col-md-4">
                                            <a class="btn btn-outline-secondary btn-sm edit"
                                                href="{{ route('customer.show', $r->id) }}" target="_blank"
                                                title="Show">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a class="btn btn-outline-secondary btn-sm edit"
                                                href="{{ route('customer.edit', $r->id) }}" target="_blank"
                                                title="Edit">
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
            Showing {{ ($data->currentPage() - 1) * $data->perPage() + ($data->total() ? 1 : 0) }} to
            {{ ($data->currentPage() - 1) * $data->perPage() + count($data) }} of {{ $data->total() }} Results
            <div id="pagination" class="d-flex justify-content-center">
                {!! $data->links() !!}
            </div>
            <!-- end row-->
            <div class="modal fade" id="listmodal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Search Result</h5>
                            <button onclick="clickCloseForm(event)" type="button" class="btn-close"
                                data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <button onclick="clickCloseForm(event)" class="btn btn-primary" data-bs-target=""
                                data-bs-toggle="modal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchCustomer() {
            var searchTextAny = $('#search-box_any').val().toLowerCase();
            var search_id = $('#search_id').val().toLowerCase();
            var search_tax_id = $('#search_tax_id').val().toLowerCase();
            var search_name = $('#search_name').val().toLowerCase();
            var search_mobile_no = $('#search_mobile_no').val().toLowerCase();

            $.ajax({

                url: "{{ route('load.customer.table.search') }}",
                type: "GET",
                data: {
                    search_text: searchTextAny,
                    search_id: search_id,
                    search_tax_id: search_tax_id,
                    search_name: search_name,
                    search_mobile_no: search_mobile_no
                },
                success: function(data) {
                    $("#tableBody").empty();
                    // Loop through the response and add new rows to the table
                    var user_type = data[data.length - 1];
                    $.each(data[0], function(index, item) {
                        var row = $("<tr>");
                        // Create table cells and populate them with data
                        var cell1 = $("<td style='width:10%'>").text(item.id);
                        var cell2 = $("<td style='width:20%'>").text(item.customertype);
                        var cell3 = $("<td style='width:20%'>").text(item.taxid);
                        var cell4 = $("<td style='width:25%'>").text(item.fullname);
                        var cell5 = $("<td style='width:25%'>").text(item.mobile);
                        var cell6 = $("<td style='width:0%'>").text("");
                        // Add more cells as needed
                        var htmlContentAdmin =
                            '<div style="width:100px" class="row">' +
                            '<div class="col-md-4">' +
                            '<a class="btn btn-outline-secondary btn-sm edit" href="/customer/show/' +
                            item.id + '" target="_blank" title="Show">' +
                            "<i class='fas fa-eye'></i>" +
                            "</a>" +
                            "</div>" +
                            '<div class="col-md-4">' +
                            '<a class="btn btn-outline-secondary btn-sm" href="/customer/edit/' + item
                            .id + '" target="_blank" title="Show">' +
                            "<i class='fas fa-pencil-alt'></i>" +
                            "</a>" +
                            "</div>" +
                            '<div class="col-md-4">' +
                            '<a class="btn btn-danger btn-sm edit" href="/customer/delete/' + item.id +
                            '" target="_blank" title="Show">' +
                            "<i class='fas fa-trash'></i>" +
                            "</a>" +
                            "</div>" +
                            "</div>";
                        var htmlContentUser =
                            '<div style="width:100px" class="row">' +
                            '<div class="col-md-4">' +
                            '<a class="btn btn-outline-secondary btn-sm edit" href="/customer/show/' +
                            item.id + '" target="_blank" title="Show">' +
                            "<i class='fas fa-eye'></i>" +
                            "</a>" +
                            "</div>" +
                            '<div class="col-md-4">' +
                            '<a class="btn btn-outline-secondary btn-sm" href="/customer/edit/' + item
                            .id + '" target="_blank" title="Show">' +
                            "<i class='fas fa-pencil-alt'></i>" +
                            "</a>" +
                            "</div>" +
                            "</div>";
                        if (user_type == "admin")
                            var cell7 = $("<td style='width:3%'>").html(htmlContentAdmin);
                        else
                            var cell7 = $("<td style='width:3%'>").html(htmlContentUser);
                        // Append the cells to the row
                        row.append(cell1, cell2, cell3, cell4, cell5, cell6, cell7);
                        // Append the row to the table body
                        $("#tableBody").append(row);
                    });
                }
            });
        };
    </script>

    <script>
        $("#search-box_any").on("keyup", function() {
            searchCustomer();
        });
        $("#search_id").on("keyup", function() {
            searchCustomer();
        });

        $("#search_tax_id").on("keyup", function() {
            searchCustomer();
        });
        $("#search_name").on("keyup", function() {
            searchCustomer();
        });
        $("#search_mobile_no").on("keyup", function() {
            searchCustomer();
        });

        document.getElementById("btn_clear_filters").addEventListener("click", function(event) {
            event.preventDefault();
            window.location.href = '/customer/data/simple';
        });
    </script>
@endsection
