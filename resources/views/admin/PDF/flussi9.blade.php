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
    <title>Proposta del Contratto di soggiorno</title>
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
        Prefettura di RM<br>
        </p>
        
        <h5 align="center"><b>PROPOSTA</b></h5>
        <h5 align="center"><b>DEL CONTRATTO DI SOGGIORNO</b></h5>

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
        <h5 align="center"><b>PROPONE</b></h5>
        <br>
        <table>
            <tr>
                <td text-align="justify">l'assunzione a tempo @if(!empty($pdfdata['tempo'][0]->field_value)){{$pdfdata['tempo'][0]->field_value}}@endif
                    per mesi @if(!empty($pdfdata['mesi_lavoro'][0]->field_value)){{$pdfdata['mesi_lavoro'][0]->field_value}}@endif
                    presso la nostra struttura in :
                </td>
            </tr>
        </table>

        <table style="width:100%">
            <tr>
                <td colspan="3" style="border: 1px solid black;"><b>SEDE OPERATIVA</b></td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid black;">Indirizzo : @if(!empty($pdfdata['indirizzo_operativa'][0]->field_value)){{$pdfdata['indirizzo_operativa'][0]->field_value}}@endif</td>
            </tr>
            <tr>
                <td style="border: 1px solid black;">
                    Citta : @if(!empty($pdfdata['citta_operativa'][0]->field_value)){{$pdfdata['citta_operativa'][0]->field_value}}@endif 
                </td>
                <td style="border: 1px solid black;">
                    Provincia : @if(!empty($pdfdata['provincia_operativa'][0]->field_value)){{$pdfdata['provincia_operativa'][0]->field_value}}@endif
                </td>
                <td style="border: 1px solid black;">
                    CAP : @if(!empty($pdfdata['cap_operativa'][0]->field_value)){{$pdfdata['cap_operativa'][0]->field_value}}@endif
                </td>
            </tr>
        </table>
        
        <br>
        <table>
            <tr>
                <td text-align="justify">per Il/la cittadino/a extracomunitario/a Signor/ra
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
        <table>
            <tr>
                <td>
                    per le seguenti mansioni : @if(!empty($pdfdata['mansoine'][0]->field_value)){{$pdfdata['mansoine'][0]->field_value}}@endif<br>
                    con facoltà da parte dell’azienda di successiva assegnazione a mansioni diverse riconducibili allo stesso livello e categoria legale di inquadramento.<br>
                    L'inquadramento sarà con la qualifica di operaio/dipendente nel livello @if(!empty($pdfdata['livello_categoria'][0]->field_value)){{$pdfdata['livello_categoria'][0]->field_value}}@endif 
                    e con un orario settimanale di @if(!empty($pdfdata['orario_settimanale'][0]->field_value)){{$pdfdata['orario_settimanale'][0]->field_value}}@endif<br>
                    Si precisa che il rapporto di lavoro sarà regolato, sia per gli aspetti economici che normativi, dal vigente contratto collettivo di lavoro del settore 
                    @if(!empty($pdfdata['tempo'][0]->field_value)){{$pdfdata['tempo'][0]->field_value}}@endif<br>
                </td>
            </tr>
        </table>
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