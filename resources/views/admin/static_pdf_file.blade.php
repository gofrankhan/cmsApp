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
                    url: '/add/delete_pdf_file/' + _id,
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

<script>
  $(document).ready(function() {
    $('#pdf_category').change(function() {
      var value = $(this).val();
      $.ajax({
        url: "{{ route('load.services') }}",
        type: "GET",
        data: { value: value },
        success: function(data) {
          $("#pdf_service").empty();
          $("#pdf_service").append("<option value=''>Select a service</option>");
          $.each(data, function(index, item) {
            $("#pdf_service").append("<option value='" + item.service + "'>" + item.service + "</option>");
          });
        }
      });
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
                        <a href="" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#pdfModal">Upload PDF File</a>
                    </div>
                </p>

                <!-- sample modal content -->
                <div class="modal fade" id="pdfModal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Upload Static PDF File</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post" action="{{ route('upload.pdf.file')}}" enctype="multipart/form-data" id="form1">
                                @csrf
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <label for="upload_type" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="pdf_file_name" placeholder="Enter PDF File Name" type="text" id="pdf_file_name" >
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <label for="upload_type" class="col-sm-2 col-form-label">Category</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" name="pdf_category" aria-label="Default select example" id="pdf_category">
                                                <option selected value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->category }}">{{ $category->category }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="upload_type" class="col-sm-2 col-form-label">Service</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" id="pdf_service" name="pdf_service">
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="file_id" class="btn btn-primary" value="">
                                    <div class="row mb-3">
                                        <label for="profile_image" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="upload_pdf_file" type="file" id="upload_pdf_file">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="profile_image" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                            <input type="submit" href="" class="btn btn-primary waves-effect waves-light" value="Upload File">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

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
                                <a type="submit" class="btn btn-danger btn-sm edit" href="{{ route('delete.static.pdf.file' ,$pdf_file->id) }}" title="Delete">
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