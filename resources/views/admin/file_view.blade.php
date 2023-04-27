@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@php 
    $file_id =  $files[0]->file_id;
    $status = $files[0]->status;
    $badge_status = "";
    if($status == 'Submitted')
        $badge_status = "bg-dark";
    else if ($status == 'Pending')
        $badge_status = "bg-warning";
    else if ($status == 'Cancelled')
        $badge_status = "bg-danger";
    else if ($status == 'Completed')
        $badge_status = "bg-success";
@endphp

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h1>File #{{ $file_id }}</h1>
                    <span STYLE="font-size:18px" class="badge rounded-pill {{$badge_status}}">{{ $status }}</span>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('file.data', 'all')}}">Files</a></li>
                        <li class="breadcrumb-item active"><a href="">View</a></li>
                    </ol>
                </div>
                </div>
            </div>
        </div>
        <div class="row bottom-space"></div>
        <div class="row mb-3">
            <div class="col-sm-8"></div>
            <div class="col-sm-2">
                <div class="dropdown ">
                    <button class="form-control btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Prints <i class="mdi mdi-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if($files[0]->service == 'ARCHIVIO DSU' || $files[0]->service == 'ARCHIVIO DSU CORRENTE' )
                        <a class="dropdown-item" href="{{ route ('delega.dsu', $files[0]->customer_id)}}" target="_blank">DELEGA DSU</a>
                        @endif
                        @if($files[0]->service == 'ARCHIVIO 730')
                        <a class="dropdown-item" href="{{ route ('delega.730', $files[0]->customer_id)}}" target="_blank">DELEGA 730</a>
                        @endif
                        <a class="dropdown-item" href="#">Anagrafica Cliente</a>
                        <a class="dropdown-item" href="#">Lettera Di Benvenuto</a>
                        <a class="dropdown-item" href="#">Ricevuta di Pagamento</a>
                    </div>
                </div>
            </div> 
            <div class="col-sm-2">
                <button type="button" class="form-control btn btn-primary">Submit</button> 
            </div>  
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-2">
                        <label for="service" class="col-form-label">Service</label>
                    </div>
                    <div class="col-sm-10">
                        <input class="form-control" name="service" placeholder="Service" type="text" id="service" value="{{ $files[0]->service }}" disabled>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-2">
                        <label for="customer" class="col-form-label">Customer</label>
                    </div>
                    <div class="col-sm-8">
                        <input class="form-control" name="customer" placeholder="Customer" type="text" id="customer" value="{{ $files[0]->customer }}" disabled>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{route('customer.show',$files[0]->customer_id)}}" target="_blank">View</a>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-1">
                        <label for="shop" class="col-form-label">Shop</label>
                    </div>
                    <div class="col-sm-9">
                        <select class="form-select" name="shop" id="shop">
                            <option value="{{ $files[0]->shop }}" disabled>{{ $files[0]->shop }}</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input type="button" class="form-control btn btn-primary" name="shop_btn" id="shop_btn" value="Update" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="pagamento" class="col-form-label">Pagamento</label>
                        <input class="form-control" name="pagamento" type="text" id="pagamento" value="{{ $files[0]->price }}" disabled>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="file_status" class="col-form-label">Update Status</label>
                        <input class="form-control" name="file_status"  type="text" id="file_status" value="{{ $files[0]->status }}" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="ARCHIVIO DSU" class="col-form-label">ARCHIVIO DSU</label>
                        <input class="form-control" name="ARCHIVIO DSU" placeholder="ARCHIVIO DSU" type="text" id="ARCHIVIO DSU" disabled>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br>
        <div class="row">
            <div class="col">
                <form method="post" action="{{ route('post.comment')}}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="basicpill-address-input"><h3>Comments</h3></label>
                        <textarea id="basicpill-address-input" name="comment" class="form-control" placeholder="Add comments here" rows="4"></textarea>
                    </div>
                    <input type="hidden" name="file_id" class="btn btn-primary waves-effect waves-light" value="{{ $file_id }}">
                   <div class="mb-3">
                        <input type="submit" href="" class="btn btn-primary waves-effect waves-light" value="Post Comments">
                    </div>
                </form>
                <br>
                <div class="row mb-3">
                    <table class="table table-sm m-0">
                        <tbody>
                            @foreach ($comments as $comment)
                                @php
                                    $user = Illuminate\Support\Facades\DB::table('users')->where('username', $comment->username)->first();
                                    if($user != null && $user->user_type == 'admin')
                                        $card_type = "bg-warning";
                                    else 
                                        $card_type = "bg-primary";
                                @endphp
                            <tr>
                                <div>
                                    <div class="card {{$card_type}} text-black-50" style="opacity: 0.75;">
                                        <div class="card-body">
                                            @php
                                                $user = Illuminate\Support\Facades\DB::table('users')->where('username', $comment->username)->first();
                                            @endphp
                                            <div class="row mb-4 text-black"><i>Created At : {{ $comment->created_at }} || By : @if($user != null) {{ $user->name }} @else Unknown User @endif || Status : Pending</i></div>
                                            <div class="card-text">
                                                <p style="color: black">
                                                    <b>{{ $comment->comment }}</b>
                                                </p>
                                                <form id="myForm2" action="{{ route('delete.comment') }}" method="post">
                                                    @csrf
                                                    <div align="right">
                                                        <input type="hidden" id="comment_id" name="id" value="{{ $comment->id }}">
                                                        @if($status != 'Completed')
                                                        <a type="submit" class="btn btn-danger btn-sm edit" onclick="document.getElementById('myForm2').submit();" title="Delete">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                        @endif
                                                    </div>
                                                </form>
                                            </div>  
                                        </div>      
                                    </div>
                                </div>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col">
                <form method="post" id="downloadForm" action="{{ route('download.file', $file_id )}}">
                    @csrf 
                    <div class="row mb-3">
                        <label for="category" class="col-sm-3 col-form-label"><h3>Attachments</h3></label>
                        <div class="col-sm-1">
                            <a class="btn btn-primary" onclick="document.getElementById('downloadForm').submit();" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                </form>
                <form method="post" action="{{ route('upload.file')}}" enctype="multipart/form-data">
                    @csrf    
                    <div class="row mb-3">
                        <label for="upload_type" class="col-sm-2 col-form-label">Upload Type</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="upload_type" aria-label="Default select example" id="upload_type">
                                <option selected="" hidden></option>
                                @php
                                    $upload_types = Illuminate\Support\Facades\DB::table('upload_types')->get();
                                @endphp
                                @foreach($upload_types as $upload_type)
                                    <option value="{{ $upload_type->upload_type }}">{{ $upload_type->upload_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="file_id" class="btn btn-primary" value="{{ $file_id }}">
                    <div class="row mb-3">
                        <label for="profile_image" class="col-sm-2 col-form-label">Upload File</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="upload_file" type="file" id="upload_file">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="profile_image" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <input type="submit" href="" class="btn btn-primary waves-effect waves-light" value="Upload File">
                        </div>
                    </div>
                </form>
                <div class="row mb-3">
                    <table class="table table-sm m-0">
                        <tbody>
                            @foreach ($attachments as $attachment)
                                @php
                                    $user = Illuminate\Support\Facades\DB::table('users')->where('username', $attachment->username)->first();
                                    if($user != null && $user->user_type == 'admin') 
                                        $card_type = "bg-warning";
                                    else 
                                        $card_type = "bg-primary";
                                @endphp
                            <tr>
                                <div>
                                    <div class="card {{$card_type}} text-black-50' }}" style="opacity: 0.75;">
                                        <div class="card-body">
                                            <div class="row mb-4 text-black"><i>Uploaded On : {{ $attachment->created_at }} || By : @if($user != null)  {{ $user->name }} @else Unknown User @endif  || Status : Pending</i></div>
                                            <div class="card-text text-black"><a style="color: blue" href="{{  asset('upload/file_attachments/'.$attachment->file_id.'/'.$attachment->file_name) }}" target="_blank">{{ $attachment->file_name }}</a>
                                                <div align="right">
                                                    @if($status != 'Completed')
                                                    <a href="{{route('delete.file',$attachment->id )}}" type="submit" class="btn btn-danger btn-sm edit" title="Delete">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>
                                                    @endif
                                                </div>
                                        </div>      
                                    </div>
                                </div>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection