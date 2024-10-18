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

@php 
    $file_id =  $files[0]->file_id;
    $status = $files[0]->status;
    $user_type = Auth::user()->user_type;
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
                        <li class="breadcrumb-item"><a href="{{ route('file.data.simple', 'all')}}">Files</a></li>
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
                        @if($files[0]->service == 'IMMIGRAZIONE' || $files[0]->service == 'FLUSSI 2023' )
                        <a class="dropdown-item" href="{{ route ('flussi1', $files[0]->id)}}" target="_blank">Privacy e GDPR</a>
                        <a class="dropdown-item" href="{{ route ('flussi2', $files[0]->id)}}" target="_blank">Mandato Flussi</a>
                        <a class="dropdown-item" href="{{ route ('flussi3', $files[0]->id)}}" target="_blank">Delega Domanda Flussi</a>
                        <a class="dropdown-item" href="{{ route ('flussi4', $files[0]->id)}}" target="_blank">Impegno Ospitalità lavoratore Flussi</a>
                        <a class="dropdown-item" href="{{ route ('flussi5', $files[0]->id)}}" target="_blank">Impegno certificato idoneita Alloggiativa</a>
                        <a class="dropdown-item" href="{{ route ('flussi6', $files[0]->id)}}" target="_blank">Impegno DURC</a>
                        <a class="dropdown-item" href="{{ route ('flussi7', $files[0]->id)}}" target="_blank">Impegno Documentoo Asseverazione</a>
                        <a class="dropdown-item" href="{{ route ('flussi8', $files[0]->id)}}" target="_blank">Autodichiarazione previdenziale e Fisacale</a>
                        <a class="dropdown-item" href="{{ route ('flussi9', $files[0]->id)}}" target="_blank">Proposta del Contratto di soggiorno</a>
                        <a class="dropdown-item" href="{{ route ('flussi10', $files[0]->id)}}" target="_blank">Dichiarazione Centri per l'impiego</a>
                        @endif
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
                        <a class="dropdown-item" href="{{ route ('delega.inps.pdf', $files[0]->customer_id)}}">DELEGA INPS</a>
                        <a class="dropdown-item" href="{{ route ('delega.di.lavoro.domestico', $files[0]->id)}}">Delega per la gestione del rapporto di lavoro domestico</a>
                        @php
                            $pdf_files = Illuminate\Support\Facades\DB::table('pdf_files')->get();
                            $service_db = Illuminate\Support\Facades\DB::table('services')->where('service', $files[0]->service)->first();
                            $category_name = $service_db->category;
                        @endphp
                        @foreach ($pdf_files as $pdf_file)
                            @if($pdf_file->service == '')
                                @if($category_name == $pdf_file->category)
                                <a class="dropdown-item" href="{{ route ('print.static.pdf', $pdf_file->id)}}">{{ $pdf_file->pdf_file_name }}</a>
                                @endif
                            @elseif($files[0]->service == $pdf_file->service)
                            <a class="dropdown-item" href="{{ route ('print.static.pdf', $pdf_file->id)}}">{{ $pdf_file->pdf_file_name }}</a>
                            @endif
                        @endforeach
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
            @if($user_type == 'user' || $user_type == 'admin')
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="pagamento" class="col-form-label">Pagamento</label>
                        <input class="form-control" name="pagamento" type="text" id="pagamento" value="{{ $files[0]->price }}" disabled>
                    </div>
                </div>
            </div>
            @endif
            @if($user_type == 'lawyer' || $user_type == 'admin')
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="pagamento" class="col-form-label">Pagamento [Lawyer]</label>
                        <input class="form-control" name="pagamento_lawyer" type="text" id="pagamento_lawyer" value="{{ $files[0]->lawyer_price }}" disabled>
                    </div>
                </div>
            </div>
            @endif
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="file_status" class="col-form-label">Update Status</label>
                        <input class="form-control" name="file_status"  type="text" id="file_status" value="{{ $files[0]->status }}" disabled>
                    </div>
                </div>
            </div>
        </div>
        @if($files[0]->service == 'ASSUNZIONE/LAVORO DOMESTICO')
        <div class="row">
            <label class="col-form-label"><h5>GENERALITA' DEL LAVORATORE</h5></label>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="cognome" class="col-form-label">Cognome</label>
                        <input disabled class="form-control" name="cognome" type="text" id="cognome" value="@if(!empty($pdfdata['cognome'][0]->field_value)){{$pdfdata['cognome'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="nome" class="col-form-label">Nome</label>
                        <input disabled class="form-control" name="nome" type="text" id="nome" value="@if(!empty($pdfdata['nome'][0]->field_value)){{$pdfdata['nome'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="luogo_nascita" class="col-form-label">Luogo_di_Nascita</label>
                        <input disabled class="form-control" name="luogo_di_nascita" type="text" id="luogo_di_nascita" value="@if(!empty($pdfdata['luogo_di_nascita'][0]->field_value)){{$pdfdata['luogo_di_nascita'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="data_nascita" class="col-form-label">Data_di_Nascita</label>
                        <input disabled class="form-control" name="data_di_nascita" type="date" id="data_di_nascita" value="@if(!empty($pdfdata['data_di_nascita'][0]->field_value)){{$pdfdata['data_di_nascita'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="sesso" class="col-form-label">Sesso_MF</label>
                        <input disabled class="form-control" name="sesso_mf" type="text" id="sesso_mf" value="@if(!empty($pdfdata['sesso_mf'][0]->field_value)){{$pdfdata['sesso_mf'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label class="col-form-label"><h5>INDIRIZZO DEL LAVORATORE</h5></label>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="indirizzo" class="col-form-label">Indirizzo</label>
                        <input disabled class="form-control" name="indirizzo" type="text" id="indirizzo" value="@if(!empty($pdfdata['indirizzo'][0]->field_value)){{$pdfdata['indirizzo'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="citta" class="col-form-label">Comune</label>
                        <input disabled class="form-control" name="comune" type="text" id="comune" value="@if(!empty($pdfdata['comune'][0]->field_value)){{$pdfdata['comune'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="provincia" class="col-form-label">Provincia</label>
                        <input disabled class="form-control" name="provincia" type="text" id="provincia" value="@if(!empty($pdfdata['provincia'][0]->field_value)){{$pdfdata['provincia'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="cap" class="col-form-label">CAP</label>
                        <input disabled class="form-control" name="cap" type="text" id="cap" value="@if(!empty($pdfdata['cap'][0]->field_value)){{$pdfdata['cap'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="telefono" class="col-form-label">Telefono</label>
                        <input disabled class="form-control" name="telefono" type="number" id="telefono" value="@if(!empty($pdfdata['telefono'][0]->field_value)){{$pdfdata['telefono'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="cellulare" class="col-form-label">Cellulare</label>
                        <input disabled class="form-control" name="cellulare" type="number" id="cellulare" value="@if(!empty($pdfdata['cellulare'][0]->field_value)){{$pdfdata['cellulare'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label class="col-form-label"><h5>TIPO CONTRATTO</h5></label>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="determinato_data" class="col-form-label">Determinato_Data</label>
                        <input disabled class="form-control" name="determinato_data" type="date" id="determinato_data" value="@if(!empty($pdfdata['determinato_data'][0]->field_value)){{$pdfdata['determinato_data'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="provincia" class="col-form-label">Indeterminato_X</label>
                        <input disabled class="form-control" name="indeterminato_x" type="text" id="indeterminato_x" value="@if(!empty($pdfdata['indeterminato_x'][0]->field_value)){{$pdfdata['indeterminato_x'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="data_assunzione" class="col-form-label">Data_assunzione</label>
                        <input disabled class="form-control" name="data_assunzione" type="date" id="data_assunzione" value="@if(!empty($pdfdata['data_assunzione'][0]->field_value)){{$pdfdata['data_assunzione'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="ore_settimanali" class="col-form-label">Ore_settimanali</label>
                        <input disabled class="form-control" name="ore_settimanali" type="number" id="ore_settimanali" value="@if(!empty($pdfdata['ore_settimanali'][0]->field_value)){{$pdfdata['ore_settimanali'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="retribuzione_mensile" class="col-form-label">Retribuzione_mensile</label>
                        <input disabled class="form-control" name="retribuzione_mensile" type="number" id="retribuzione_mensile" value="@if(!empty($pdfdata['retribuzione_mensile'][0]->field_value)){{$pdfdata['retribuzione_mensile'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label class="col-form-label"><h5>SEDE LAVORO(se diverso dalla residenza del datore di lavoro)</h5></label>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="indirizzo_sede" class="col-form-label">Indirizzo_sede</label>
                        <input disabled class="form-control" name="indirizzo_sede" type="text" id="indirizzo_sede" value="@if(!empty($pdfdata['indirizzo_sede'][0]->field_value)){{$pdfdata['indirizzo_sede'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="comune_sede" class="col-form-label">Comune_sede</label>
                        <input disabled class="form-control" name="comune_sede" type="text" id="comune_sede" value="@if(!empty($pdfdata['comune_sede'][0]->field_value)){{$pdfdata['comune_sede'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="provincia_sede" class="col-form-label">Provincia_sede</label>
                        <input disabled class="form-control" name="provincia_sede" type="text" id="provincia_sede" value="@if(!empty($pdfdata['provincia_sede'][0]->field_value)){{$pdfdata['provincia_sede'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="cap_sede" class="col-form-label">CAP_sede</label>
                        <input disabled class="form-control" name="cap_sede" type="text" id="cap_sede" value="@if(!empty($pdfdata['cap_sede'][0]->field_value)){{$pdfdata['cap_sede'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label class="col-form-label"><h5>Orario di lavoro</h5></label>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="lunedi_dalle_mattina" class="col-form-label">Lunedi_dalle_mattina</label>
                        <input disabled class="form-control" name="lunedi_dalle_mattina" type="number" id="lunedi_dalle_mattina" value="@if(!empty($pdfdata['lunedi_dalle_mattina'][0]->field_value)){{$pdfdata['lunedi_dalle_mattina'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="martedi_dalle_mattina" class="col-form-label">Martedi_dalle_mattina</label>
                        <input disabled class="form-control" name="martedi_dalle_mattina" type="number" id="martedi_dalle_mattina" value="@if(!empty($pdfdata['martedi_dalle_mattina'][0]->field_value)){{$pdfdata['martedi_dalle_mattina'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="mercoledi_dalle_mattina" class="col-form-label">Mercoledi_dalle_mattina</label>
                        <input disabled class="form-control" name="mercoledi_dalle_mattina" type="number" id="mercoledi_dalle_mattina" value="@if(!empty($pdfdata['mercoledi_dalle_mattina'][0]->field_value)){{$pdfdata['mercoledi_dalle_mattina'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="giovedi_dalle_mattina" class="col-form-label">Giovedi_dalle_mattina</label>
                        <input disabled class="form-control" name="giovedi_dalle_mattina" type="number" id="giovedi_dalle_mattina" value="@if(!empty($pdfdata['giovedi_dalle_mattina'][0]->field_value)){{$pdfdata['giovedi_dalle_mattina'][0]->field_value}}@endif">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="venerdi_dalle_mattina" class="col-form-label">Venerdi_dalle_mattina</label>
                        <input disabled class="form-control" name="venerdi_dalle_mattina" type="number" id="venerdi_dalle_mattina" value="@if(!empty($pdfdata['venerdi_dalle_mattina'][0]->field_value)){{$pdfdata['venerdi_dalle_mattina'][0]->field_value}}@endif" disabled>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="sabato_dalle_mattina" class="col-form-label">Sabato_dalle_mattina</label>
                        <input disabled class="form-control" name="sabato_dalle_mattina" type="number" id="sabato_dalle_mattina" value="@if(!empty($pdfdata['sabato_dalle_mattina'][0]->field_value)){{$pdfdata['sabato_dalle_mattina'][0]->field_value}}@endif" disabled>
                    </div>
                </div>
            </div>
        </div>
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
                                            <div class="row mb-4 text-black"><i>Uploaded On : {{ $attachment->created_at }} || By : @if($user != null)  {{ $user->name }} @else Unknown User @endif  || Status : Pending</i></div>
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