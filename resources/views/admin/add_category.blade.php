@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="row mb-3">
                    <label for="category" class="col-sm-2 col-form-label">Add Category</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="category" placeholder="Add Category" type="text" id="category" >
                    </div>
                    <div class="col-sm-2">
                        <input  type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Add">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="sub_category" class="col-sm-2 col-form-label">Add Sub Category</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="sub_category" placeholder="Add Sub Category" type="text" id="sub_category" >
                    </div>
                    <div class="col-sm-2">
                        <input  type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Add">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label">Select Categories</label>
                    <div class="col-sm-8">
                        <select class="select2 form-control select2-multiple"
                            multiple="multiple" data-placeholder="Choose ...">
                            <optgroup label="Category">
                                <option value="category1">Category1</option>
                                <option value="category2">Category2</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>     
        </div> 
    </div>
</div>
@endsection