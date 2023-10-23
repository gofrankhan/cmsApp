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
                        @if($files[0]->service == 'FLUSSI 2023' )
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
            @if($files[0]->service == 'FLUSSI 2023')
            <div class="row">
                <label class="col-form-label"><h5>Lavoratore</h5></label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="nome" class="col-form-label">Nome</label>
                            <input class="form-control" name="nome" type="text" id="nome" value="@if(!empty($pdfdata['nome'][0]->field_value)){{$pdfdata['nome'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="cognome" class="col-form-label">Cognome</label>
                            <input class="form-control" name="cognome" type="text" id="cognome" value="@if(!empty($pdfdata['cognome'][0]->field_value)){{$pdfdata['cognome'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="luogo_nascita" class="col-form-label">Luogo Nascita</label>
                            <input class="form-control" name="luogo_nascita" type="text" id="luogo_nascita" value="@if(!empty($pdfdata['luogo_nascita'][0]->field_value)){{$pdfdata['luogo_nascita'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="data_nascita" class="col-form-label">Data Nascita</label>
                            <input class="form-control" name="data_nascita" type="date" id="data_nascita" value="@if(!empty($pdfdata['data_nascita'][0]->field_value)){{$pdfdata['data_nascita'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="sesso" class="col-form-label">Sesso</label>
                            <input class="form-control" name="sesso" type="text" id="sesso" value="@if(!empty($pdfdata['sesso'][0]->field_value)){{$pdfdata['sesso'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="cittadinanza" class="col-form-label">Cittadinanza</label>
                            <input class="form-control" name="cittadinanza" type="text" id="cittadinanza" value="@if(!empty($pdfdata['cittadinanza'][0]->field_value)){{$pdfdata['cittadinanza'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="paese_residenza" class="col-form-label">Paese Residenza</label>
                            <input class="form-control" name="paese_residenza" type="text" id="paese_residenza" value="@if(!empty($pdfdata['paese_residenza'][0]->field_value)){{$pdfdata['paese_residenza'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label"><h5>Datore di Lavoro</h5></label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="ragione_sociale" class="col-form-label">Ragione sociale</label>
                            <input class="form-control" name="ragione_sociale" type="text" id="ragione_sociale" value="@if(!empty($pdfdata['ragione_sociale'][0]->field_value)){{$pdfdata['ragione_sociale'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="cf_azienda" class="col-form-label">CF Azienda</label>
                            <input class="form-control" name="cf_azienda" type="text" id="cf_azienda" value="@if(!empty($pdfdata['cf_azienda'][0]->field_value)){{$pdfdata['cf_azienda'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="flussi_partita_iva" class="col-form-label">Partita Iva</label>
                            <input class="form-control" name="flussi_partita_iva" type="text" id="flussi_partita_iva" value="@if(!empty($pdfdata['flussi_partita_iva'][0]->field_value)){{$pdfdata['flussi_partita_iva'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label"><h5>Sede Legale azienda</h5></label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="indirizzo_sede" class="col-form-label">Indirizzo sede</label>
                            <input class="form-control" name="indirizzo_sede" type="text" id="indirizzo_sede" value="@if(!empty($pdfdata['indirizzo_sede'][0]->field_value)){{$pdfdata['indirizzo_sede'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="citta_sede" class="col-form-label">Citta Sede</label>
                            <input class="form-control" name="citta_sede" type="text" id="citta_sede" value="@if(!empty($pdfdata['citta_sede'][0]->field_value)){{$pdfdata['citta_sede'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="provincia_sede" class="col-form-label">Provincia sede</label>
                            <input class="form-control" name="provincia_sede" type="text" id="provincia_sede" value="@if(!empty($pdfdata['provincia_sede'][0]->field_value)){{$pdfdata['provincia_sede'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="cap_sede" class="col-form-label">CAP sede</label>
                            <input class="form-control" name="cap_sede" type="text" id="cap_sede" value="@if(!empty($pdfdata['cap_sede'][0]->field_value)){{$pdfdata['cap_sede'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label"><h5>Sede operativa di lavoro</h5></label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="indirizzo_operativa" class="col-form-label">Indirizzo operativa</label>
                            <input class="form-control" name="indirizzo_operativa" type="text" id="indirizzo_operativa" value="@if(!empty($pdfdata['indirizzo_operativa'][0]->field_value)){{$pdfdata['indirizzo_operativa'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="citta_operativa" class="col-form-label">Citta operativa</label>
                            <input class="form-control" name="citta_operativa" type="text" id="citta_operativa" value="@if(!empty($pdfdata['citta_operativa'][0]->field_value)){{$pdfdata['citta_operativa'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="provincia_operativa" class="col-form-label">Provincia operativa</label>
                            <input class="form-control" name="provincia_operativa" type="text" id="provincia_operativa" value="@if(!empty($pdfdata['provincia_operativa'][0]->field_value)){{$pdfdata['provincia_operativa'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="cap_operativa" class="col-form-label">CAP operativa</label>
                            <input class="form-control" name="cap_operativa" type="text" id="cap_operativa" value="@if(!empty($pdfdata['cap_operativa'][0]->field_value)){{$pdfdata['cap_operativa'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label"><h5>Dati azinedali inps e inali</h5></label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="matricola_inps" class="col-form-label">Matricola INPS</label>
                            <input class="form-control" name="matricola_inps" type="text" id="matricola_inps" value="@if(!empty($pdfdata['matricola_inps'][0]->field_value)){{$pdfdata['matricola_inps'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="sede_inail" class="col-form-label">Sede INAIL</label>
                            <input class="form-control" name="sede_inail" type="text" id="sede_inail" value="@if(!empty($pdfdata['sede_inail'][0]->field_value)){{$pdfdata['sede_inail'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="codice_inail" class="col-form-label">Codice INAIL</label>
                            <input class="form-control" name="codice_inail" type="text" id="codice_inail" value="@if(!empty($pdfdata['codice_inail'][0]->field_value)){{$pdfdata['codice_inail'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="controllo_inail" class="col-form-label">Controllo INAIL</label>
                            <input class="form-control" name="controllo_inail" type="text" id="controllo_inail" value="@if(!empty($pdfdata['controllo_inail'][0]->field_value)){{$pdfdata['controllo_inail'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="provincia_cciaa" class="col-form-label">Provincia CCIAA</label>
                            <input class="form-control" name="provincia_cciaa" type="text" id="provincia_cciaa" value="@if(!empty($pdfdata['provincia_cciaa'][0]->field_value)){{$pdfdata['provincia_cciaa'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="numero_cciaa" class="col-form-label">Numero CCIAA</label>
                            <input class="form-control" name="numero_cciaa" type="text" id="numero_cciaa" value="@if(!empty($pdfdata['numero_cciaa'][0]->field_value)){{$pdfdata['numero_cciaa'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="data_iscrizione" class="col-form-label">Data Iscrizione</label>
                            <input class="form-control" name="data_iscrizione" type="text" id="data_iscrizione" value="@if(!empty($pdfdata['data_iscrizione'][0]->field_value)){{$pdfdata['data_iscrizione'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="numero_dipendenti" class="col-form-label">Numero Dipendenti</label>
                            <input class="form-control" name="numero_dipendenti" type="text" id="numero_dipendenti" value="@if(!empty($pdfdata['numero_dipendenti'][0]->field_value)){{$pdfdata['numero_dipendenti'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="codice_sdi" class="col-form-label">Codice SDI</label>
                            <input class="form-control" name="codice_sdi" type="text" id="codice_sdi" value="@if(!empty($pdfdata['codice_sdi'][0]->field_value)){{$pdfdata['codice_sdi'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="fatturato_annoprima" class="col-form-label">Fatturato annoprima</label>
                            <input class="form-control" name="fatturato_annoprima" type="text" id="fatturato_annoprima" value="@if(!empty($pdfdata['fatturato_annoprima'][0]->field_value)){{$pdfdata['fatturato_annoprima'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="redditi_annoprima" class="col-form-label">Redditi annoprima</label>
                            <input class="form-control" name="redditi_annoprima" type="text" id="redditi_annoprima" value="@if(!empty($pdfdata['redditi_annoprima'][0]->field_value)){{$pdfdata['redditi_annoprima'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label"><h5>Dati relativi all'assunzione</h5></label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="tipologia_contratto" class="col-form-label">Tipologia contratto</label>
                            <input class="form-control" name="tipologia_contratto" type="text" id="tipologia_contratto" value="@if(!empty($pdfdata['tipologia_contratto'][0]->field_value)){{$pdfdata['tipologia_contratto'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="tempo" class="col-form-label">Tempo</label>
                            <input class="form-control" name="tempo" type="text" id="tempo" value="@if(!empty($pdfdata['tempo'][0]->field_value)){{$pdfdata['tempo'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="mansoine" class="col-form-label">Mansoine</label>
                            <input class="form-control" name="mansoine" type="text" id="mansoine" value="@if(!empty($pdfdata['mansoine'][0]->field_value)){{$pdfdata['mansoine'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="mesi_lavoro" class="col-form-label">Mesi lavoro</label>
                            <input class="form-control" name="mesi_lavoro" type="text" id="mesi_lavoro" value="@if(!empty($pdfdata['mesi_lavoro'][0]->field_value)){{$pdfdata['mesi_lavoro'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="orario_settimanale" class="col-form-label">Orario settimanale</label>
                            <input class="form-control" name="orario_settimanale" type="text" id="orario_settimanale" value="@if(!empty($pdfdata['orario_settimanale'][0]->field_value)){{$pdfdata['orario_settimanale'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="livello_categoria" class="col-form-label">Livello categoria</label>
                            <input class="form-control" name="livello_categoria" type="text" id="livello_categoria" value="@if(!empty($pdfdata['livello_categoria'][0]->field_value)){{$pdfdata['livello_categoria'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label"><h5>Idoenita Alloggiativa</h5></label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="indirizzo_lav" class="col-form-label">IndirizzoLav</label>
                            <input class="form-control" name="indirizzo_lav" type="text" id="indirizzo_lav" value="@if(!empty($pdfdata['indirizzo_lav'][0]->field_value)){{$pdfdata['indirizzo_lav'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="civico_lav" class="col-form-label">CivicoLav</label>
                            <input class="form-control" name="civico_lav" type="text" id="civico_lav" value="@if(!empty($pdfdata['civico_lav'][0]->field_value)){{$pdfdata['civico_lav'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="cap_lav" class="col-form-label">CapLav</label>
                            <input class="form-control" name="cap_lav" type="text" id="cap_lav" value="@if(!empty($pdfdata['cap_lav'][0]->field_value)){{$pdfdata['cap_lav'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="citta_lav" class="col-form-label">CittaLav</label>
                            <input class="form-control" name="citta_lav" type="text" id="citta_lav" value="@if(!empty($pdfdata['citta_lav'][0]->field_value)){{$pdfdata['citta_lav'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="provincia_lav" class="col-form-label">ProvinciaLav</label>
                            <input class="form-control" name="provincia_lav" type="text" id="provincia_lav" value="@if(!empty($pdfdata['provincia_lav'][0]->field_value)){{$pdfdata['provincia_lav'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            @endif
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
                            <label for="flussi_partita_iva" class="col-form-label">Partita IVA</label>
                            <input class="form-control" name="flussi_partita_iva" type="text" id="flussi_partita_iva" value="@if(!empty($pdfdata['flussi_partita_iva'][0]->field_value)){{$pdfdata['flussi_partita_iva'][0]->field_value}}@endif">
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