@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer Informations</h4>
                        <p class="card-title-desc" >
                            <div align="right">
                                <a href="{{ route('customer.new') }}" class="btn btn-primary waves-effect waves-light">New</a>
                            </div>
                        </p>

                        <table id="alternative-page-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Tax ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        
                        
                            <tbody>
                                @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->customertype }}</td>
                                    <td>{{ $customer->taxid }}</td>
                                    @if($customer->customertype == 'company')<td>{{ $customer->company}}</td>
                                    @else <td> {{ $customer->firstname." ".$customer->lastname }}</td>
                                    @endif
                                    <td>
                                        <form action="{{ route('customer.delete',$customer->id) }}" method="Post">
                                            <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('customer.show',$customer->id) }}" target="_blank" title="Show">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('customer.edit',$customer->id) }}" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <a type="submit" class="btn btn-outline-secondary btn-sm edit" href="{{ route('customer.delete' ,$customer->id) }}" title="Delete">
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