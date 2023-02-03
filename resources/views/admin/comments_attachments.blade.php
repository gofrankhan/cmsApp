@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <form method="post" action="{{ route('post.comment')}}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="basicpill-address-input"><h3>Comments</h3></label>
                        <textarea id="basicpill-address-input" name="comment" class="form-control" placeholder="Add comments here" rows="4"></textarea>
                    </div>
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
                                    if($user->user_type == 'admin') 
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
                                            <div class="row mb-4 text-black"><i>Created At : {{ $comment->created_at }} || By : {{ $user->name }} || Status : Pending</i></div>
                                            <div class="card-text"><p style="color: black"><b>{{ $comment->comment }}</b></p>
                                            <form action="" method="Post">
                                                <div align="right">
                                                    <a class="btn btn-secondary btn-sm edit" href="" title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <a type="submit" class="btn btn-danger btn-sm edit" href="" title="Delete">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </form>  
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
                <form method="post" action="{{ route('upload.file')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="category" class="col-sm-2 col-form-label"><h3>Attachments</h3></label>
                    </div>    
                    <div class="row mb-3">
                        <label for="category" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="category" aria-label="Default select example" id="category">
                                <option selected="" hidden></option>
                                <option value="category1">Category 1</option>
                                <option value="category2">Category 2</option>
                                <option value="category3">Category 3</option>
                                <option value="category4">Category 4</option>
                            </select>
                        </div>
                    </div>
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
                                    if($user->user_type == 'admin') 
                                        $card_type = "bg-warning";
                                    else 
                                        $card_type = "bg-primary";
                                @endphp
                            <tr>
                                <div>
                                    <div class="card {{$card_type}} text-black-50' }}" style="opacity: 0.75;">
                                        <div class="card-body">
                                            <div class="row mb-4 text-black"><i>Uploaded On : {{ $attachment->created_at }} || By : {{ $user->name }} || Status : Pending</i></div>
                                            <div class="card-text text-black"><a style="color: blue" href="{{  asset('upload/file_attachments/12650304/'.$attachment->file_name) }}" target="_blank">{{ $attachment->file_name }}</a>
                                            <form action="" method="Post">
                                                <div align="right">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a type="submit" class="btn btn-danger btn-sm edit" href="" title="Delete">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </form>  
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