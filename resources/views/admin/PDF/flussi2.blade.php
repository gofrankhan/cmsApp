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
    <title>Mandato Flussii</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="abcdx"> 
        <h5 align="center"><b>PROCURA SPECIALE</b></h5>
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
        <table>
            <tr>
                <td style="text-align:justify">Il   sottoscritto   {{ $customer->firstname." ".$customer->lastname }}   nato   in   {{ $customer->pob }} 
                    in  data   {{ $date1."/".$month1."/".$year1; }}   in
                    qualità di rappresentante legale della società/ditta @if(!empty($pdfdata['ragione_sociale'][0]->field_value)){{$pdfdata['ragione_sociale'][0]->field_value}}@endif con
                    codice partita iva @if(!empty($pdfdata['flussi_partita_iva'][0]->field_value)){{$pdfdata['flussi_partita_iva'][0]->field_value}}@endif
                    e sede legale @if(!empty($pdfdata['indirizzo_sede'][0]->field_value)){{$pdfdata['indirizzo_sede'][0]->field_value}}@endif
                    in @if(!empty($pdfdata['citta_sede'][0]->field_value)){{$pdfdata['citta_sede'][0]->field_value}}@endif 
                    (@if(!empty($pdfdata['provincia_sede'][0]->field_value)){{$pdfdata['provincia_sede'][0]->field_value}}@endif) 
                    e @if(!empty($pdfdata['cap_sede'][0]->field_value)){{$pdfdata['cap_sede'][0]->field_value}}@endif
                    nella pratica di seguito meglio descritto: "preparazione e trasmissione telematica della richiesta di flussi immigratori per 
                    lavoratori extracomunitari e comunitari per lavoro subordinato stagionale/non stagionale/domestico e ritiro del nulla-osta", 
                    informato ai sensi dell’art.4, 3° comma, del d.lgs. n. 28/2010 della possibilità di ricorrere al procedimento di mediazione ivi 
                    previsto e dei benefici fiscali di cui agli artt. 17 e 20 del medesimo decreto, delega alla rappresentanza e alla intermediazione 
                    nella presente procedura, con ogni potere di legge, compresa la facoltà di conciliare, quietanzare, incassare, 
                    farsi sostituire, chiamare terzi in causa anche in garanzia, nonché rinunciare agli atti, il Sig. Chakraborty Nibash 
                    (C.F. CHKNSH89P01Z249C) in qualità di operatore 
                    L'ASSOCIAZIONE UCI ZONALE TUSCOLANO STILICONE con sede in ROMA, VIa Flavio Stilicone 11, 00175, 
                    ove elegge domicilio.
                    La presente procura annulla tutte le altre precedenti. Dichiaro altresì di essere stata edotto che il trattamento 
                    dei miei dati avverrà solo in esecuzione del mandato e pertanto autorizzo il medesimo incaricato al trattamento dei 
                    miei dati personali conformemente alle norme del D.Lgs. 196/2013 
                    e GDPR 679/2019 e limitatamente alle finalità connesse all’esecuzione del presente mandato.
                </td>
            </tr>
        </table>
        <br>
        <p>In fede.</p>
        <table>
            <tr>
                <td>ROMA</td>
                <td>________________</td>
            </tr>
        </table>
        
        <p style="text-align:right">{{ $customer->firstname." ".$customer->lastname }}</p>
        <p style="text-align:right">_____________________</p>
        <p>Nibash Chakraborty</p>
        <p>________________________</p>
    </div>
</body>
</html>