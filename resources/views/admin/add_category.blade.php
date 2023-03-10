@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('select.form-select').change(function(e){
            $('#div_new_categroy').hide();
            var selectValue = $(this).children("option:selected").val();
            if(selectValue === "create_new"){
                $('#div_new_categroy').show();
            }else{
                $('#div_new_categroy').hide();
            }
        });
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
    var maxField1 = 10; //Input fields increment limitation
    var addButton1 = $('#add_button1'); //Add button selector
    var wrapper1 = $('#field_wrapper1'); //Input field wrapper
    var fieldHTML1 = '<div class="row mb-3"><div class="col-sm-8"><input class="form-control" name="category[]" placeholder="Category Name" type="text" id="category" ></div><div class="col-sm-2">
    <input  type="submit" id="remove_button1" class="btn btn-rounded btn-sm btn-outline-danger waves-effect waves-light" value="-"></div></div>'; //New input field html 
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

<script type="text/javascript">
$(document).ready(function(){
    var maxField2 = 10; //Input fields increment limitation
    var addButton2 = $('#add_button2'); //Add button selector
    var wrapper2 = $('#field_wrapper2'); //Input field wrapper
    var fieldHTML2 = 
    '<div class="row mb-3">'+
        '<div class="col-sm-7">'+
            '<input class="form-control" name="service[]" placeholder="Service Name" type="text" id="service" >'+
        '</div>'+
        '<div class="col-sm-3">'+
            '<input class="form-control" name="price[]" placeholder="price" type="number" id="price" >'+
        '</div>'+
        '<div class="col-sm-2">'+
            '<input  type="submit" id="remove_button2" class="btn btn-rounded btn-sm btn-outline-danger waves-effect waves-light" value="-">'+
        '</div>'+
    '</div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton2).click(function(){
        //Check maximum number of input fields
        if(x < maxField2){ 
            x++; //Increment field counter
            $(wrapper2).append(fieldHTML2); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper2).on('click', '#remove_button2', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <form method="post" action="{{ route('add.category') }}">
                    @csrf
                    <div id="field_wrapper1">
                        <div class="row mb-3">
                            <label for="category" class="col-form-label">Create Service Category</label>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <input class="form-control" name="category[]" placeholder="Category Name" type="text" id="category" >
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
            
            <div class="col">
                <form method="post" action="{{ route('add.service') }}">
                    @csrf
                    <div id="field_wrapper2">
                        <div class="row mb-3">
                            <label for="category" class="col-form-label">Create Category / Service</label>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <select class="form-select" name="service_category" aria-label="Default select example" id="service_category">
                                    <option selected value="create_new">Create New Caregory</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3" id="div_new_categroy">
                            <div class="col-sm-10">
                                <input class="form-control" name="new_category" placeholder="New Category Name" type="text" id="new_category" >
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-7">
                                <input class="form-control" name="service[]" placeholder="Service Name" type="text" id="service_name" >
                            </div>
                            <div class="col-sm-3">
                                <input class="form-control" name="price[]" placeholder="Price" type="number" id="price" >
                            </div>
                            <div class="col-sm-2">
                                <input style="width:30px" id="add_button2" class="btn btn-sm btn-outline-primary btn-rounded waves-effect waves-light" value="+">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <input  type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Submit">
                    </div>
                </form>
            </div>

                <div class="col">
                    <form method="post" action="{{ route('add.service_category') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="sub_category" class="col-form-label">Create Service</label>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-7">
                                <input class="form-control" name="service" placeholder="Service Name" type="text" id="service" >
                            </div>
                            <div class="col-sm-3">
                                <input class="form-control" name="price" placeholder="Price" type="number" id="price" >
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <select class="select2 form-control select2-multiple" name="category[]"
                                    multiple="multiple" data-placeholder="Select Category ...">
                                    <optgroup label="Category">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                                    @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <input  type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" value="Submit">
                        </div>
                    </form>
                </div>
            </div>     
        </div> 
    </div>
</div>
@endsection