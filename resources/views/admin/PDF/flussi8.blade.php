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
    <title>Autodichiarazione previdenziale e Fisacale</title>
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
        
        <h5 align="center"><b>DICHIARAZIONE SOSTITUTIVA DI CERTIFICAZIONE</b></h5>
        <h5 align="center"><b>(Art. 46 D.P .R. n. 445 del 28 dicembre 2000)</b></h5>

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
        <table>
            <tr>
                <td text-align="justify">Sotto la sua personale responsabilità ed a piena conoscenza della responsabilità
                            penale prevista per le dichiarazioni false dall’art.76 del D.P.R. 445/2000 e dalle
                            disposizioni del Codice Penale e dalle leggi speciali in materia
                </td>
            </tr>
        </table>
        <br><br>
        <h5 align="center"><b>DICHIARA</b></h5>
        <br>
        <table>
            <tr>
                <td text-align="justify">- che la sede legale dell'impresa è la seguente:
                </td>
            </tr>
        </table>

        <table style="width:100%">
            <tr>
                <td colspan="3" style="border: 1px solid black;"><b>SEDE LEGALE</b></td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid black;">Indirizzo : @if(!empty($pdfdata['indirizzo_sede'][0]->field_value)){{$pdfdata['indirizzo_sede'][0]->field_value}}@endif</td>
            </tr>
            <tr>
                <td style="border: 1px solid black;">
                    Citta : @if(!empty($pdfdata['citta_sede'][0]->field_value)){{$pdfdata['citta_sede'][0]->field_value}}@endif 
                </td>
                <td style="border: 1px solid black;">
                    Provincia : @if(!empty($pdfdata['provincia_sede'][0]->field_value)){{$pdfdata['provincia_sede'][0]->field_value}}@endif
                </td>
                <td style="border: 1px solid black;">
                    CAP : @if(!empty($pdfdata['cap_sede'][0]->field_value)){{$pdfdata['cap_sede'][0]->field_value}}@endif
                </td>
            </tr>
        </table>
        
        <br>
        <table>
            <tr>
                <td text-align="justify">- che la posizione fiscale e previdenziale sono le seguenti :
                </td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td colspan="2" style="border: 1px solid black;"><b>POSIZIONI FISCALI E PREVIDENZIALI</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid black;">
                    Matricola INPS 
                </td>
                <td style="border: 1px solid black;">
                    <b>@if(!empty($pdfdata['matricola_inps'][0]->field_value)){{$pdfdata['matricola_inps'][0]->field_value}}@endif</b>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black;">
                    Codice Azienda INAIL
                </td>
                <td  style="border: 1px solid black;">
                    <b>@if(!empty($pdfdata['codice_inail'][0]->field_value)){{$pdfdata['codice_inail'][0]->field_value}}@endif</b>
                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td>
                <i>Dichiara altresì di essere informato, ai sensi e per gli effetti di cui all'art.10 della
                legge 675/96, che i dati personali raccolti saranno trattati, anche con strumenti
                informatici, esclusivamente nell'ambito del procedimento per il quale la presente
                dichiarazione viene resa</i><br>
                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td>Luogo e data {{ $customer->city }} ___/___/______</td>
                <td style="width:240px"> </td>
                <td align="right">Firma _________________</td>
            </tr>
        </table>
    </div>
</body>
</html>