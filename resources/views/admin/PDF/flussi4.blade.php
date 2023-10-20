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
    <title>Impegno Ospitalità lavoratore Flussi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="abcdx"> 
        <p>CHAKRBAORTY NIBASH<br>
        @if(!empty($pdfdata['indirizzo_sede'][0]->field_value)){{$pdfdata['indirizzo_sede'][0]->field_value}}@endif<br>
        @if(!empty($pdfdata['cap_sede'][0]->field_value)){{$pdfdata['cap_sede'][0]->field_value}}@endif - 
        @if(!empty($pdfdata['citta_sede'][0]->field_value)){{$pdfdata['citta_sede'][0]->field_value}}@endif 
        (@if(!empty($pdfdata['provincia_sede'][0]->field_value)){{$pdfdata['provincia_sede'][0]->field_value}}@endif)<br>
        @if(!empty($pdfdata['flussi_partita_iva'][0]->field_value)){{$pdfdata['flussi_partita_iva'][0]->field_value}}@endif<br>
        </p>

        <p align="right" padding="0px">Spett.le,<br>
        Sportello Unico Immigrazione<br>
        Prefettura di RM<br>
        </p>
        
        <h5 align="center"><b>DICHIARAZIONE DI IMPEGNO</b></h5>
        <h5 align="center"><b>A FORNIRE LA CESSIONE DI FABBRICATO</b></h5>

        <table>
            <tr>
                <td text-align="justify">Il   sottoscritto   {{ $customer->firstname." ".$customer->lastname }}   nato   in   {{ $customer->citizenship }}  
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
                    qualità di rappresentante legale della società/ditta {{$user->shop_name}} con
                    codice partita iva @if(!empty($pdfdata['flussi_partita_iva'][0]->field_value)){{$pdfdata['flussi_partita_iva'][0]->field_value}}@endif
                    e sede legale @if(!empty($pdfdata['indirizzo_sede'][0]->field_value)){{$pdfdata['indirizzo_sede'][0]->field_value}}@endif
                    in @if(!empty($pdfdata['citta_sede'][0]->field_value)){{$pdfdata['citta_sede'][0]->field_value}}@endif 
                    (@if(!empty($pdfdata['provincia_sede'][0]->field_value)){{$pdfdata['provincia_sede'][0]->field_value}}@endif) 
                    e @if(!empty($pdfdata['cap_sede'][0]->field_value)){{$pdfdata['cap_sede'][0]->field_value}}@endif
                </td>
            </tr>
        </table>
        <br><br>
        <h5 align="center"><b>SI IMPEGNA</b></h5>
        <br>
        <table>
            <tr>
                <td text-align="justify">ad ospitare presso il proprio domicilio sito in
                    @if(!empty($pdfdata['citta_lav'][0]->field_value)){{$pdfdata['citta_lav'][0]->field_value}}@endif
                    nella provincia di @if(!empty($pdfdata['provincia_lav'][0]->field_value)){{$pdfdata['provincia_lav'][0]->field_value}}@endif
                    all'indirizzo @if(!empty($pdfdata['indirizzo_lav'][0]->field_value)){{$pdfdata['indirizzo_lav'][0]->field_value}}@endif, 
                    @if(!empty($pdfdata['civico_lav'][0]->field_value)){{$pdfdata['civico_lav'][0]->field_value}}@endif
                    e CAP @if(!empty($pdfdata['cap_lav'][0]->field_value)){{$pdfdata['cap_lav'][0]->field_value}}@endif
                </td>
            </tr>
        </table>
        
        <br>
        <table>
            <tr>
                <td text-align="justify">Il/la cittadino/a extracomunitario/a Signor/ra
                </td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td colspan="6" style="border: 1px solid black;"><b>GENERALITA' DEL LAVORATORE</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid black;">
                    Cognome 
                </td>
                <td style="border: 1px solid black;">
                    <b>@if(!empty($pdfdata['cognome'][0]->field_value)){{$pdfdata['cognome'][0]->field_value}}@endif</b>
                </td>
                <td style="border: 1px solid black;">
                    Nome
                </td>
                <td colspan="3" style="border: 1px solid black;">
                    <b>@if(!empty($pdfdata['nome'][0]->field_value)){{$pdfdata['nome'][0]->field_value}}@endif</b>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black;">
                    Luogo di Nascita
                </td>
                <td style="border: 1px solid black;">
                    <b>@if(!empty($pdfdata['luogo_nascita'][0]->field_value)){{$pdfdata['luogo_nascita'][0]->field_value}}@endif</b>
                </td>
                <td style="border: 1px solid black;">
                    Data di Nascita
                </td>
                <td style="border: 1px solid black;">
                    <b>@if(!empty($pdfdata['data_nascita'][0]->field_value)){{$pdfdata['data_nascita'][0]->field_value}}@endif</b>
                </td>
                <td style="border: 1px solid black;">
                    Sesso
                </td>
                <td style="border: 1px solid black;">
                    <b>@if(!empty($pdfdata['sesso'][0]->field_value)){{$pdfdata['sesso'][0]->field_value}}@endif</b>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>
                <td>Luogo e data @if(!empty($pdfdata['citta_sede'][0]->field_value)){{$pdfdata['citta_sede'][0]->field_value}}@endif __/__/__</td>
                <td style="width:255px"> </td>
                <td align="right">Firma _________________</td>
            </tr>
        </table>
    </div>
</body>
</html>