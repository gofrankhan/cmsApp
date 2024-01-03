@extends('admin.admin_master')
@section('admin')

<!-- AJAX script -->
<script>
    $(document).ready(function() {
        // Listen for click events on the delete icon/button
        $('#alternative-page-datatable').on('click', '.btn.btn-danger.btn-sm.edit', function(e) {
            e.preventDefault();
            var result = confirm("Want to delete?");
            if (result) {
                //Logic to delete the item
                var currentRow=$(this).closest("tr");
                var _id=currentRow.find("td:eq(0)").text();
                // Send an AJAX request to delete the row
                $.ajax({
                    url: '/client/delete/' + _id,
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

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Static PDF Files Informations</h4>
                </div>
                <p class="card-title-desc" >
                    <div align="right">
                        <a href="{{ route('client.new') }}" class="btn btn-primary waves-effect waves-light">New</a>
                    </div>
                </p>
                <table id="alternative-page-datatable" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th style="width:2%">ID</th>
                            <th style="width:8%">Name</th>
                            <th style="width:25%">File Name</th>
                            <th style="width:25%">Category</th>
                            <th style="width:35%">Service</th>
                            <th style="width:5%">Actions</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach ($pdf_files as $pdf_file)
                        <tr>
                            <td style="width:2%">{{ $pdf_file->id }}</td>
                            <td style="width:8%">{{ $pdf_file->pdf_file_name }}</td>
                            <td style="width:25%">{{ $pdf_file->upload_pdf_file }}</td>
                            <td style="width:25%">{{ $pdf_file->category }}</td>
                            <td style="width:35%">{{ $pdf_file->service }}</td>
                            <td style="width:5%">
                                    <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('client.edit' ,$pdf_file->id) }}" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a type="submit" class="btn btn-danger btn-sm edit" href="{{ route('client.delete' ,$pdf_file->id) }}" title="Delete">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div>
</div>

@endsection