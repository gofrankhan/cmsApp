@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Client Informations</h4>
                        <p class="card-title-desc" >
                            <div align="right">
                                <a href="{{ route('client.new') }}" class="btn btn-primary waves-effect waves-light">New</a>
                            </div>
                        </p>

                        <table id="alternative-page-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        
                        
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->user_type }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form action="{{ route('client.delete',$user->id) }}" method="Post">
                                            <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('client.edit' ,$user->id) }}" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <a type="submit" class="btn btn-outline-secondary btn-sm edit" href="{{ route('client.delete' ,$user->id) }}" title="Delete">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div>
</div>

@endsection