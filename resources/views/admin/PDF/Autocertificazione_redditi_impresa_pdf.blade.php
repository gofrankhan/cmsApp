<!DOCTYPE html>
@php
define("DOMPDF_ENABLE_REMOTE", false);
@endphp
<html>
<head>
<style>
p, table {
  font-size: 14px;
}
</style>
    <title>Autocertificazione redditi impresa pdf</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="abcdx">
        <div align="center" padding="0px">
            <img  src="{{ public_path('backend/assets/images/PCPoint_Logo.png') }}" height="100" width="500" alt="">
        </div>  
        <p align="center">VIA FLAVIO STILCIONE 11, 00175, ROMA (RM)<br>
        Tel- 06 8788 0399, email- <u>cafpcpoint@yahoo.com</u>, pec- <u>cafpcpoint@pec.it</u></p><br>
        <h5><b>AUTOCERTIFICAZIONE DEL REDDITO DI LAVORO AUTONOMO</b></h5>

        <table>
            <tr>
                <td style="width:140px;">Il/La sottoscritto/a   </td>    
                <td>{{ $customer->firstname." ".$customer->lastname }}<td>
                
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:56px;">nato a<td>
                <td style="width:240px;">{{ $customer->citizenship }}</td>
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
                <td style="width:8px;">il<td>
                <td style="width:180px;">{{ $date1."/".$month1."/".$year1; }}</td>
                <td style="width:105px;">e residente a<td>
                <td style="width:55px;">{{ $customer->city }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:56px;">in via<td>
                @php
                    $words = explode(' ', $customer->addressline1);
                    $last_word = array_pop($words);
                    $address1 = join(" ", $words);
                @endphp
                @if($customer->addressline2 == '-')
                <td style="width:400px;">{{ $address1}}</td>
                @else
                <td style="width:400px;">{{ $address1." " .$customer->addressline2 }}</td>
                @endif
                <td style="width:16px;">n<sup>o</sup><td>
                <td style="width:100px;">{{ $last_word }}</td>
                <td style="width:35px;">prov<td>
                <td style="width:15px;">@if(!empty($customer->region)){{ $customer->region[0].$customer->region[1] }}@endif</td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td>consapevole delle sanzioni penali previste dall’art. 76 del D.P.R. 28.12.2000 n. 445 per le ipotesi di<td>
            </tr>
        </table>
        <table>
            <tr>
                <td>falsità in atti e dichiarazioni mendaci e della decadenza dei benefici prevista dall’art. 75 del<td>
            </tr>
        </table>
        <table>
            <tr>
                <td>medesimo<td>
            </tr>
        </table>
        <table>
            <tr>
                <td>D.P.R. nel caso di dichiarazioni non veritiere<td>
            </tr>
        </table>
        <br><p style="font-size:20px" align="center">DICHIARA<br>
        <table>
            <tr>
                <td>sotto la propria responsabilità e in data odierna:<td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td>- di esercitare la seguente attività (tipo di attività): <b>@if(!empty($pdfdata['codice_ateco'][0]->field_value)){{$pdfdata['codice_ateco'][0]->field_value}}@endif - @if(!empty($pdfdata['tipo_attivita'][0]->field_value)){{$pdfdata['tipo_attivita'][0]->field_value}}@endif</b><td>
            </tr>
        </table>
        <table>
            <tr>
                <td>- di essere titolare della partita iva n° <b>@if(!empty($pdfdata['partita_iva'][0]->field_value)){{$pdfdata['partita_iva'][0]->field_value}}@endif
                    </b> e codice fiscale <b>@if(!empty($pdfdata['codice_fiscale'][0]->field_value)){{$pdfdata['codice_fiscale'][0]->field_value}}@endif
                    </b>  con sede legale in <b>@if(!empty($pdfdata['indirizzo'][0]->field_value)){{$pdfdata['indirizzo'][0]->field_value}}@endif</b>
                     civico <b>@if(!empty($pdfdata['civico'][0]->field_value)){{$pdfdata['civico'][0]->field_value}}@endif</b>
                      a <b>@if(!empty($pdfdata['citta'][0]->field_value)){{$pdfdata['citta'][0]->field_value}}@endif</b> provincia 
                      <b>@if(!empty($pdfdata['provincia'][0]->field_value)){{$pdfdata['provincia'][0]->field_value}}@endif</b> e cap 
                      <b>@if(!empty($pdfdata['cap'][0]->field_value)){{$pdfdata['cap'][0]->field_value}}@endif</b><td>
            </tr>
        </table>
        <table>
            <tr>
                <td>- di essere iscritta presso la C.C.I.A.A (nel caso di ditte individuali):<td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:80px;"></td>
                <td>- N° iscrizione<td>
                <td><b>@if(!empty($pdfdata['registration_no'][0]->field_value)){{$pdfdata['registration_no'][0]->field_value}}@endif</b></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:80px;"></td>
                <td>- Data di iscrizione<td>
                @php
                   if(!empty($pdfdata['registration_date'][0]->field_value))
                        $time=strtotime($pdfdata['registration_date'][0]->field_value);
                        $date1=date("d",$time);
                        $month1=date("m",$time);
                        $year1=date("Y",$time);
                @endphp
                <td><b>{{ $date1."/".$month1."/".$year1; }}</b></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:80px;"></td>
                <td>- Comune della camera di commercio di<td>
                <td><b>@if(!empty($pdfdata['common_chamber_of_commerce'][0]->field_value)){{$pdfdata['common_chamber_of_commerce'][0]->field_value}}@endif</b></td>
            </tr>
        </table>
        <table>
            <tr>
                <td>- di essere iscritto/a presso il seguente albo professionale (nel caso di professionisti):<td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:200px;"></td>
                <td>del comune di<td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:80px;"></td>
                <td>- N° iscrizione<td>
                <td><b>@if(!empty($pdfdata['registration_no'][0]->field_value)){{$pdfdata['registration_no'][0]->field_value}}@endif</b></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:80px;"></td>
                <td>- Data di iscrizione<td>
                <td><b>{{ $date1."/".$month1."/".$year1; }}</b></td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td>- di aver percepito durante lʼanno <b>@if(!empty($pdfdata['anno'][0]->field_value)){{$pdfdata['anno'][0]->field_value}}@endif RIF @if(!empty($pdfdata['rif'][0]->field_value)){{$pdfdata['rif'][0]->field_value}}@endif</b>
                un reddito annuo netto  di euro <b>@if(!empty($pdfdata['reddito'][0]->field_value)){{$pdfdata['reddito'][0]->field_value}}@endif
                <td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td>Autorizzo il trattamento dei miei dati personali ai sensi del D.lgs. 196 del 30 giugno 2003.<td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>
                <td style="width:175px; text-align:center;">ROMA - </td>
                <td style="width:300px;"></td>
                <td style="width:175px;"></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:175px; border-bottom: 1px solid black;"></td>
                <td style="width:300px;"></td>
                <td style="width:175px; border-bottom: 1px solid black;"></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:175px;text-align:center;">(LUOGO E DATA)</td>
                <td style="width:300px;"></td>
                <td style="width:175px;text-align:center;">(FIRMA) </td>
            </tr>
        </table>
    </div>
</body>
</html>