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
                    <h4 class="card-title">User's Informations</h4>
                </div>
                <p class="card-title-desc" >
                    <div align="right">
                        <a href="{{ route('client.new') }}" class="btn btn-primary waves-effect waves-light">New</a>
                    </div>
                </p>
                <table id="alternative-page-datatable" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Shop Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->user_type }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->shop_name }}</td>
                            <td>
                                    <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('client.edit' ,$user->id) }}" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a type="submit" class="btn btn-danger btn-sm edit" href="{{ route('client.delete' ,$user->id) }}" title="Delete">
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