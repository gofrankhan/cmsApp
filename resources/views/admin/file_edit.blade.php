@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  $(document).ready(function() {
    $('#update_btn').click(function() {
      // Get data from Modal 2
      var data = $('#form1').serialize();
      // Submit the data
      $.ajax({
        url: '{{ route('update.status.price') }}',
        method: 'POST',
        data: data,
        success: function(response) {
            window.location.reload();
        }
      });
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#category').change(function() {
      var value = $(this).val();
      if(value.toLowerCase() === 'pagamento'){
        $('#div_service').hide();
      }else{
        $('#div_service').show();
      $.ajax({
        url: "{{ route('load.services') }}",
        type: "GET",
        data: { value: value },
        success: function(data) {
          $("#service2").empty();
          $("#service2").append("<option value=''>Select a service</option>");
          $.each(data, function(index, item) {
            $("#service2").append("<option value='" + item.service + "'>" + item.service + "</option>");
          });
        }
      });
    }
    });
  });
</script>

@php 
    $user_type = Auth::user()->user_type;
    $is_admin = ($user_type == 'admin');
    $file_id =  $files[0]->file_id;
    $status = $files[0]->status;
    $badge_status = "";
    $text_selected = "selected";
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
                            <li class="breadcrumb-item"><a href="{{ route('file.data.simple', 'all')}}">Files</a></li>
                            <li class="breadcrumb-item active"><a href="">Edit</a></li>
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
                        @if($files[0]->service == 'DICHIARAZIONE REDDITI PF')
                        <a class="dropdown-item" href="{{ route ('auto.red.imp', $files[0]->id)}}" target="_blank">Autocertificazione redditi impresa</a>
                        <a class="dropdown-item" href="{{ route ('del.tra.dis', $files[0]->id)}}" target="_blank">Delega Trasmissione Dichiarazione dei Redditi</a>
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
                    <div class="col-sm-8">
                        <input class="form-control" name="service" placeholder="Service" type="text" id="service" value="{{ $files[0]->service }}">
                    </div>
                    <div class="col-sm-2">
                        <a href="" data-bs-toggle="modal" data-bs-target="#editservice">Edit</a>
                    </div>
                </div>
            </div>
            <!-- sample modal content -->
            @php
                $categories = App\Models\Category::all();
            @endphp
            <div class="modal fade" id="editservice" aria-hidden="true" aria-labelledby="..." tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('update.service')}}" id="form2" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Service</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div>
                                            <div class="mb-3">
                                                <label  class="form-label">Select Category</label>
                                                <select class="form-select" id="category" name="category">
                                                    <option value="Choose" selected>Choose...</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->category }}" >{{ $category->category }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="file_id_no" value="{{ $file_id }}">
                                    <div class="row" id="div_service">
                                        <div>
                                            <div class="mb-3">
                                                <label  class="form-label">Select Service</label>
                                                <select class="form-select" id="service2" name="service2">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            <div class="modal-footer">
                                <!-- Toogle to second dialog -->
                                <button id="update_service" type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-2">
                        <label for="customer" class="col-form-label">Customer</label>
                    </div>
                    <div class="col-sm-8">
                        <input class="form-control" name="customer" placeholder="Customer" type="text" id="customer" value="{{ $files[0]->customer }}" >
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
                            <option value="{{ $files[0]->shop }}">{{ $files[0]->shop }}</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        @if($is_admin)
                        <button type="submit" class="form-control btn btn-primary" name="update_btn" id="update_btn">Update</button>
                        @else
                        <button type="submit" class="form-control btn btn-primary" name="update_btn" id="update_btn" disabled>Update</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if($is_admin)
        <form action="" id="form1">
             @csrf
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="pagamento" class="col-form-label">Pagamento</label>
                            <input class="form-control" name="pagamento" type="text" id="pagamento" value="{{ $files[0]->price }}">
                        </div>
                    </div>
                </div>
                @if($files[0]->lawyer_id != "")
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="pagamento" class="col-form-label">Pagamento [Lawyer]</label>
                            <input class="form-control" name="pagamento_lawyer" type="text" id="pagamento_lawyer" value="{{ $files[0]->lawyer_price }}">
                        </div>
                    </div>
                </div>
                @endif
                <input hidden name="file_id_no" value="{{ $files[0]->file_id}}">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="file_status" class="col-form-label">Update Status</label>
                            <select class="form-select" name="file_status" id="file_status">
                            @if($status == 'Pending')
                                <option selected value="Pending">Pending</option>
                                <option value="Cancelled">Cancel</option>
                                <option value="Completed">Complete</option>
                            @elseif($status == 'Cancelled')
                                <option value="Pending">Pending</option>
                                <option selected value="Cancelled">Cancel</option>
                                <option value="Completed">Complete</option>
                            @elseif($status == 'Completed')
                                <option value="Pending">Pending</option>
                                <option value="Cancelled">Cancel</option>
                                <option selected value="Completed">Complete</option>
                            @else
                                <option selected hidden value="Submitted"></option>
                                <option value="Pending">Pending</option>
                                <option value="Cancelled">Cancel</option>
                                <option value="Completed">Complete</option>
                            @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            @if($files[0]->service == 'DICHIARAZIONE REDDITI PF')
            <div class="row">
                <label class="col-form-label">Sede Legale</label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="indirizzo" class="col-form-label">Indirizzo</label>
                            
                            <input class="form-control" name="indirizzo" type="text" id="indirizzo" value="@if(!empty($pdfdata['indirizzo'][0]->field_value)){{$pdfdata['indirizzo'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="civico" class="col-form-label">Civico</label>
                            <input class="form-control" name="civico" type="text" id="civico" value="@if(!empty($pdfdata['civico'][0]->field_value)){{$pdfdata['civico'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="cap" class="col-form-label">CAP</label>
                            <input class="form-control" name="cap" type="text" id="cap" value="@if(!empty($pdfdata['cap'][0]->field_value)){{$pdfdata['cap'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="citta" class="col-form-label">Citta</label>
                            <input class="form-control" name="citta" type="text" id="citta" value="@if(!empty($pdfdata['citta'][0]->field_value)){{$pdfdata['citta'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="provincia" class="col-form-label">Provincia</label>
                            <input class="form-control" name="provincia" type="text" id="provincia" value="@if(!empty($pdfdata['provincia'][0]->field_value)){{$pdfdata['provincia'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label">Dati aizendali</label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="partita_iva" class="col-form-label">Partita IVA</label>
                            <input class="form-control" name="partita_iva" type="text" id="partita_iva" value="@if(!empty($pdfdata['partita_iva'][0]->field_value)){{$pdfdata['partita_iva'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="codice_fiscale" class="col-form-label">Codice Fiscale</label>
                            <input class="form-control" name="codice_fiscale" type="text" id="codice_fiscale" value="@if(!empty($pdfdata['codice_fiscale'][0]->field_value)){{$pdfdata['codice_fiscale'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="codice_ateco" class="col-form-label">Codice Ateco</label>
                            <input class="form-control" name="codice_ateco" type="text" id="codice_ateco" value="@if(!empty($pdfdata['codice_ateco'][0]->field_value)){{$pdfdata['codice_ateco'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="tipo_attivita" class="col-form-label">Tipo Attivita</label>
                            <input class="form-control" name="tipo_attivita" type="text" id="tipo_attivita" value="@if(!empty($pdfdata['tipo_attivita'][0]->field_value)){{$pdfdata['tipo_attivita'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label">Auocertificazione di reddito da dichiarare</label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="anno" class="col-form-label">ANNO</label>
                            
                            <input class="form-control" name="anno" type="text" id="anno" value="@if(!empty($pdfdata['anno'][0]->field_value)){{$pdfdata['anno'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="rif" class="col-form-label">RIF</label>
                            <input class="form-control" name="rif" type="text" id="rif" value="@if(!empty($pdfdata['rif'][0]->field_value)){{$pdfdata['rif'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="reddito" class="col-form-label">Reddito</label>
                            <input class="form-control" name="reddito" type="text" id="reddito" value="@if(!empty($pdfdata['reddito'][0]->field_value)){{$pdfdata['reddito'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label">Compilare solo per ditte individuali iscritti alla camera di commercio</label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="registration_no" class="col-form-label">Numero iscrizione</label>
                            <input class="form-control" name="registration_no" type="text" id="registration_no" value="@if(!empty($pdfdata['registration_no'][0]->field_value)){{$pdfdata['registration_no'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="registration_date" class="col-form-label">Data iscrizione</label>
                            <input class="form-control" name="registration_date" type="date" id="registration_date" value="@if(!empty($pdfdata['registration_date'][0]->field_value)){{$pdfdata['registration_date'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="common_chamber_of_commerce" class="col-form-label">CCIAA di</label>
                            <input class="form-control" name="common_chamber_of_commerce" type="text" id="common_chamber_of_commerce" value="@if(!empty($pdfdata['common_chamber_of_commerce'][0]->field_value)){{$pdfdata['common_chamber_of_commerce'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </form>
        @endif
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
                                                        @if($user_type == 'admin')
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
                                            <div class="row mb-4 text-black"><i>Uploaded On : {{ $attachment->created_at }} || By : @if($user != null) {{ $user->name }} @else Unknown User @endif || Status : Pending</i></div>
                                            <div class="card-text text-black"><a style="color: blue" href="{{  asset('upload/file_attachments/'.$attachment->file_id.'/'.$attachment->file_name) }}" target="_blank">{{ $attachment->file_name }}</a>
                                                <div align="right">
                                                    @if($status == 'Submitted' || $user_type == 'admin')
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