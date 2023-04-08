@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    var maxField1 = 10; //Input fields increment limitation
    var addButton1 = $('#add_button1'); //Add button selector
    var wrapper1 = $('#field_wrapper1'); //Input field wrapper
    var fieldHTML1 = '<div class="row mb-3"><div class="col-sm-8"><input class="form-control" name="upload_type[]" placeholder="Upload Type" type="text" id="upload_type" ></div><div class="col-sm-2"><input  type="submit" id="remove_button1" class="btn btn-rounded btn-sm btn-outline-danger waves-effect waves-light" value="-"></div></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton1).click(function(){
        //Check maximum number of input fields
        if(x < maxField1){ 
            x++; //Increment field counter
            $(wrapper1).append(fieldHTML1); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper1).on('click', '#remove_button1', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>

<script>
  $(document).ready(function() {
    $('#category').change(function() {
      var value = $(this).val();
      $.ajax({
        url: "{{ route('load.services') }}",
        type: "GET",
        data: { value: value },
        success: function(data) {
          $("#service").empty();
          $("#service").append("<option value=''>Select a service</option>");
          $.each(data, function(index, item) {
            $("#service").append("<option value='" + item.service + "'>" + item.service + "</option>");
          });
        }
      });
    });
});
</script>

<script>
  $(document).ready(function() {
    $('#service').change(function() {
      var service = $(this).val();
      var category = $('#category').find(":selected").val();
      $.ajax({
        url: "{{ route('load.service.price') }}",
        type: "GET",
        data: { service: service, category: category},
        success: function(data) {
            $('#price').val(data.price);
        }
      });
    });
});
</script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <form method="post" action="{{ route('add.upload_type') }}">
                    @csrf
                    <div id="field_wrapper1">
                        <div class="row mb-3">
                            <label for="upload_type" class="col-form-label">Create Upload Type</label>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-8">
                                <input class="form-control" name="upload_type[]" placeholder="Upload Type" type="text" id="upload_type" >
                            </div>
                            <div class="col-sm-2">
                                <input style="width:30px" id="add_button1" class="btn btn-rounded btn-sm btn-outline-primary waves-effect waves-light" value="+">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <input  type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Submit">
                    </div>
                </form>
            </div>  
            <div  class="col">
                <form method="post" action="{{ route('update.service.price') }}">
                    @csrf
                    <div id="field_wrapper1">
                        <div class="row mb-3">
                            <label for="update" class="col-form-label">Update Service Price</label>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <select class="form-select" name="category" aria-label="Default select example" id="category">
                                    <option selected value="">Select Category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-7">
                                <select class="form-select" id="service" name="service">
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input class="form-control" name="price" placeholder="Price" type="number" id="price" >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <input  type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Update">
                    </div>
                </form>
            </div>
            <div  class="col">
                <div>
                    <div class="row mb-3">
                        <label for="update" class="col-form-label">Broadcast Message</label>
                    </div>
                    @php
                        $broadcast_messages = Illuminate\Support\Facades\DB::table('broadcast_messages')->get();
                        $broadcast_messages_count = Illuminate\Support\Facades\DB::table('broadcast_messages')->count();
                    @endphp
                    @if(($broadcast_messages_count))
                    @foreach($broadcast_messages as $broadcast_message)
                    <div class="row mb-3" id="message_card">
                        <div class="card bg-warning text-black-50" style="opacity: 0.75;">
                            <div class="card-body">
                                <div class="card-text">
                                    <p style="color: black">
                                        <b>{{ $broadcast_message->message }}</b>
                                    </p>
                                    <form id="messageForm" action="{{ route('delete.broadcast.message')}}" method="post">
                                        @csrf
                                        <div align="right">
                                            <input type="hidden" id="message_id" name="message_id" value="{{$broadcast_message->id}}">
                                            <a type="submit" class="btn btn-danger btn-sm edit" onclick="document.getElementById('messageForm').submit();" title="Delete">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </form>
                                </div>  
                            </div>      
                        </div>
                    </div>
                    @endforeach
                    @else
                    <form method="post" action="{{ route('create.broadcast.message')}}">
                        @csrf
                        <div class="row mb-3">
                            <textarea id="basicpill-address-input" name="message" class="form-control" placeholder="Message" rows="4"></textarea>
                        </div>
                        <div class="col-sm-2">
                            <input type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Save">
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection