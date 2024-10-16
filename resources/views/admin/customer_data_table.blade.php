@extends('admin.admin_master')
@section('admin')

<script>
    function submitForm(event) {
        event.preventDefault();
        var taxidOrNameOrMobile = $('#search-box').val();
        $('#search-box').attr('disabled', 'disabled');
        $.ajax({
        url: "{{ route('customer.search') }}",
        type: "GET",
        data: { taxidOrNameOrMobile : taxidOrNameOrMobile },
        success: function(data) {
          $('#btn_modal').click();
          $.each(data, function(index, item) {
            $("#modal_label").append($('<a>', {
                href: "/customer/show/" + item.id,
                text: item.taxid,
                target: "_blank"
            }));
            $("#modal_label").append("<br>");
          });
        }
      });
    }
    function clickCloseForm(event){
        $('#search-box').removeAttr('disabled');
        $('#search-box').val("");
        location.reload(true);
    }
</script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Customer's Information</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('customer.data')}}">Customers</a></li>
                        </ol>
                    </div>
                </div>
                <p class="card-title-desc" >
                    <div class="row mb-3">
                        <div class="col-sm-8">
                            <form class="app-search d-none d-lg-block" data-backdrop="static" data-keyboard="false" onsubmit="submitForm(event)">
                                <div class="position-relative">
                                    <input name="search-box" id="search-box" type="text" class="form-control" placeholder="Search By Tax ID, Name or Mobile No.">
                                    <span class="ri-search-line"></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3" align="right">
                        <button type="button" hidden id="btn_modal" data-bs-target="#listmodal" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-primary waves-effect waves-light">New</button>
                        </div>
                        <div class="col-sm-1" align="right">
                            <a href="{{ route('customer.new') }}" class="btn btn-primary waves-effect waves-light">New</a>
                        </div>
                    </div>
                </p>
                <table data-page-length='50' id="customer_datatable" class="table table-bordered customer_datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Tax ID</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                
                    <tbody></tbody>
                </table>
            </div><!-- end col-->
        </div>
        <!-- end row-->
        <div class="modal fade" id="listmodal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Search Result</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="form1">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div>
                                    <div id="modal_label" class="mb-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <!-- Toogle to second dialog -->
                        <button onclick="clickCloseForm(event)" class="btn btn-primary" data-bs-target="" data-bs-toggle="modal" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

