@extends('admin.admin_master')
@section('admin')
<div>
    <label class="form-label">Select Category</label>

    <select class="select2 form-control select2-multiple"
        multiple="multiple" data-placeholder="Choose ...">
        <optgroup label="Category">
            <option value="category1">Category1</option>
            <option value="category2">Category2</option>
        </optgroup>
    </select>
</div>
@endsection