@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <form method="post" action="{{ route('post.comment')}}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="basicpill-address-input">Comments</label>
                        <textarea id="basicpill-address-input" name="comment" class="form-control" placeholder="Add comments here" rows="4"></textarea>
                    </div>
                   <div class="mb-3">
                        <input type="submit" href="" class="btn btn-primary waves-effect waves-light" value="Post Comments">
                    </div>
                </form>
                <br><br>
                <div class="row mb-3">
                    <table class="table table-sm m-0">
                        <thead>
                            <tr>
                                <th style="width:20px">Comments</th>
                                <th>File ID</th>
                                <th>Comment By</th>
                                <th>Comment At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                            <tr>
                                <td style="width:20px">{{ $comment->comment }}</td>
                                <td>{{ $comment->file_id }}</td>
                                <td>{{ $comment->username }}</td>
                                <td>{{ $comment->created_at }}</td>
                                <td>
                                    <form action="" method="Post">
                                        <a class="btn btn-outline-secondary btn-sm edit" href="" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <a type="submit" class="btn btn-outline-secondary btn-sm edit" href="" title="Delete">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </form>
                                </td>
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
                        <label for="image" class="col-sm-2 col-form-label">Attachments</label>
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
                        <thead>
                            <tr>
                                <th style="width:20px">File Name</th>
                                <th>Category</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attachments as $attachment)
                            <tr>
                                <td style="width:20px"> <a href={{  asset('upload/file_attachments/12650304/'.$attachment->file_name) }} target="_blank">{{ $attachment->file_name }}</a></td>
                                <td>{{ $attachment->category }}</td>
                                <td>{{ $attachment->username }}</td>
                                <td>{{ $attachment->created_at }}</td>
                                <td>
                                    <form action="" method="Post">
                                        <a class="btn btn-outline-secondary btn-sm edit" href="" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <a type="submit" class="btn btn-outline-secondary btn-sm edit" href="" title="Delete">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </form>
                                </td>
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