@extends('admin.admin_master')
@section('admin')

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
                    <li class="breadcrumb-item active"><a href="{{ route('movement.data')}}">Movement</a></li>
                </ol>
            </div>
        </div>
        <p class="card-title-desc" >
            <div align="right">
                <a href="" hidden class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=""></a>
            </div>
        </p>
        <table data-page-length='50' id="movement_datatable_all" class="table table-bordered movement_datatable_all">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
        
            <tbody></tbody>
        </table>
    </div><!-- end col-->
</div>
@endsection

