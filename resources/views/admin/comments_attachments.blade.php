@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label class="form-label" for="basicpill-firstname-input">Comments</label>
                    <input type="text" class="form-control" id="basicpill-firstname-input">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basicpill-address-input">Address</label>
                    <textarea id="basicpill-address-input" class="form-control" placeholder="Add comments here" rows="2"></textarea>
                </div>
                <a href="{{ route('customer.new') }}" class="btn btn-primary waves-effect waves-light">Post</a>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label class="form-label" for="basicpill-lastname-input">Attachments</label>
                    <input type="text" class="form-control" id="basicpill-lastname-input">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basicpill-lastname-input">Attachments</label>
                    <input type="text" class="form-control" id="basicpill-lastname-input">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basicpill-lastname-input">Attachments</label>
                    <input type="text" class="form-control" id="basicpill-lastname-input">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection