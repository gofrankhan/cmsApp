<!DOCTYPE html>
@php
define("DOMPDF_ENABLE_REMOTE", false);
@endphp
<html>
<head>
<style>
p, table {
  font-size: 16px;
}
</style>
    <title>Impegno DURC</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="abcdx"> 
        <p>{{ $customer->lastname." ".$customer->firstname }}<br>
        {{ $customer->addressline1 }}<br>
        {{ $customer->postcode }}, {{ $customer->city }} {{ $customer->region }}<br>
        {{ $customer->taxid }}<br>
        </p>

        <p align="right" padding="0px">Spett.le,<br>
        Sportello Unico Immigrazione<br>
        Prefettura di {{ $customer->region }}<br>
        </p>
        
        <h6 align="center"><b>DICHIARAZIONE DI IMPEGNO</b></h6>
        <h6 align="center"><b>A FORNIRE IL D.U.R.C</b></h6> 

        <table>
            <tr>
                <td text-align="justify">Il   sottoscritto   {{ $customer->firstname." ".$customer->lastname }}   nato   in   {{ $customer->pob }}  
                        @php
                        if($customer->dateofbirth == '0000-00-00')
                        {
                            $date1="00";
                            $month1="00";
                            $year1="0000";
                        }else{
                            $time=strtotime($customer->dateofbirth);
                            $date1=date("d",$time);
                            $month1=date("m",$time);
                            $year1=date("Y",$time);
                        }
                    @endphp
                    in  data   {{ $date1."/".$month1."/".$year1; }}   in
                    qualità di rappresentante legale della società/ditta @if(!empty($pdfdata['ragione_sociale'][0]->field_value)){{$pdfdata['ragione_sociale'][0]->field_value}}@endif 
                    con codcie fiscale - @if(!empty($pdfdata['cf_azienda'][0]->field_value)){{$pdfdata['cf_azienda'][0]->field_value}}@endif,
                    codice partita iva - @if(!empty($pdfdata['flussi_partita_iva'][0]->field_value)){{$pdfdata['flussi_partita_iva'][0]->field_value}}@endif
                    e sede legale @if(!empty($pdfdata['indirizzo_sede'][0]->field_value)){{$pdfdata['indirizzo_sede'][0]->field_value}}@endif
                    in @if(!empty($pdfdata['citta_sede'][0]->field_value)){{$pdfdata['citta_sede'][0]->field_value}}@endif 
                    (@if(!empty($pdfdata['provincia_sede'][0]->field_value)){{$pdfdata['provincia_sede'][0]->field_value}}@endif) 
                    e CAP @if(!empty($pdfdata['cap_sede'][0]->field_value)){{$pdfdata['cap_sede'][0]->field_value}}@endif
                </td>
            </tr>
        </table>
        <br><br>
        <h6 align="center"><b>SI IMPEGNA</b></h6>
        <br>
        <table>
            <tr>
                <td text-align="justify">a consegnare il D.U.R.C (Documento Unico di Regolarità Contributiva) in
                                originale, su richiesta da parte dello sportello unico per l'immigrazione, in fase di
                                istruttoria dell'istanza di Flussi Immigratori.
                </td>
            </tr>
        </table>
        
        <br>
        <br>
        <table>
            <tr>
                <td>Luogo e data {{ $customer->city }} ___/___/______</td>
                <td style="width:240px"> </td>
                <td align="right">Firma _________________</td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>
                <td><i>
                Autodichiarazione come da indicazioni nel portale Ali (ATTENZIONE: NEL CASO IN
                CUI AL MOMENTO DELLA COMPILAZIONE DELL'ISTANZA NON FOSSERO
                DISPONIBILI TUTTI I DOCUMENTI ORIGINALI, SI PREGA DI CARICARE
                ALTRETTANTE DICHIARAZIONI DI IMPEGNO A CONSEGNARE GLI ORIGINALI DEI
                DOCUMENTI MANCANTI. L'ACQUISIZIONE DELLA DOCUMENTAZIONE
                ORIGINALE SARA' IN TAL CASO RICHIESTA IN FASE DI ISTRUTTORIA DA PARTE
                DELLO SPORTELLO UNICO PER L'IMMIGRAZIONE.)<br></i>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>