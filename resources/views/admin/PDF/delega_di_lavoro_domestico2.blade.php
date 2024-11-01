<!DOCTYPE html>

<html>
<head>
<style>

div.nwew23 {
  margin-top: 0px;
  margin-bottom: 5px;
  margin-right: 5px;
  margin-left: 5px;
}

td.lastone {
  text-align: center;
}

div {
  margin-top: 20px;
  margin-bottom: 20px;
  margin-right: 10px;
  margin-left: 10px;
}

li {
  font-size: 12px;
  width: 100%;
}

p {
  font-size: 12px;
  width: 100%;
}
table {
  font-size: 10px;
  width: 100%;
}

table, th, td {

  border: 0.5px solid black;
  border-collapse: collapse;
}

</style>
    <title>Delega Di Lavoro Domestico</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div>
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

        <!-- 
        <div class="nwew23">   
            <div align="center">
                <img  src="{{asset('backend/assets/images/unicolf.jpeg') }}" height="100" width="500"  alt="">
            </div> 
        </div>
         -->
        <h5 style="text-align:center">Delega per la gestione del rapporto di lavoro domestico</h5>
        <br>
        <p>
        Io sottoscritto {{ $customer->firstname }} {{ $customer->lastname }}, nato/a a {{ $customer->pob }} il 
        {{ $date1."/".$month1."/".$year1; }}, residente in {{ $customer->addressline1 }} {{ $customer->addressline2 }}
         , codice fiscale {{$customer->taxid}}
         </p>
        <b>DELEGO</b>
        <br>
        <p>
        il/la Sig./Sig.ra ra POPY CHAKRABORTY, nato/a a CUMILLA (BGD) il 02/01/1992, codice fiscale
        CHKPPY92A42Z249O, residente in ROMA, PIAZZA SAN GIOVANNI BOSCO 5,
        </p>
        <p>
        a gestire il rapporto di lavoro domestico per conto del sottoscritto con le seguenti indicazioni
        </p>
        <table>
            <tr>
                <td colspan='6'><b>GENERALITA' DEL LAVORATORE</b></td>
            </tr>
            <tr>
                <td>Cognome</td>
                <td><b>@if(!empty($pdfdata['cognome'][0]->field_value)){{$pdfdata['cognome'][0]->field_value}}@endif</b></td>
                <td>Nome</td>
                <td colspan='3'><b> @if(!empty($pdfdata['nome'][0]->field_value)){{$pdfdata['nome'][0]->field_value}}@endif</b></td>
            </tr>
            <tr>
                <td>Luogo di Nascita</td>
                <td><b> @if(!empty($pdfdata['luogo_di_nascita'][0]->field_value)){{$pdfdata['luogo_di_nascita'][0]->field_value}}@endif</b></td>
                <td>Data di Nascita</td>
                <td><b>@if(!empty($pdfdata['data_di_nascita'][0]->field_value)){{$pdfdata['data_di_nascita'][0]->field_value}}@endif</b></td>
                <td>Sesso</td>
                <td>@if(!empty($pdfdata['sesso_mf'][0]->field_value)){{$pdfdata['sesso_mf'][0]->field_value}}@endif</td>
            </tr>
        </table>
        <table>
            <tr>
                <td colspan='6'><b>INDIRIZZO DEL LAVORATORE</b></td>
            </tr>
            <tr>
                <td>Indirizzo</td>
                <td colspan='5'><b>@if(!empty($pdfdata['indirizzo'][0]->field_value)){{$pdfdata['indirizzo'][0]->field_value}}@endif</b></td>
            </tr>
            <tr>
                <td>Comune</td>
                <td><b>@if(!empty($pdfdata['comune'][0]->field_value)){{$pdfdata['comune'][0]->field_value}}@endif</b></td>
                <td>Provincia</td>
                <td><b>@if(!empty($pdfdata['provincia'][0]->field_value)){{$pdfdata['provincia'][0]->field_value}}@endif</b></td>
                <td>CAP</td>
                <td><b>@if(!empty($pdfdata['cap'][0]->field_value)){{$pdfdata['cap'][0]->field_value}}@endif</b></td>
            </tr>
            <tr>
                <td>Telefono</td>
                <td><b>@if(!empty($pdfdata['telefono'][0]->field_value)){{$pdfdata['telefono'][0]->field_value}}@endif</b></td>
                <td>Cellulare</td>
                <td><b>@if(!empty($pdfdata['cellulare'][0]->field_value)){{$pdfdata['cellulare'][0]->field_value}}@endif</b></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table>
            <tr>
                <td colspan='6'><b>TIPO CONTRATTO</b></td>
            </tr>
            <tr>
                <td>Determinato fino alla data</td>
                <td><b>@if(!empty($pdfdata['determinato_data'][0]->field_value)){{$pdfdata['determinato_data'][0]->field_value}}@endif</b></td>
                <td>Indeterminato</td>
                <td>@if(!empty($pdfdata['indeterminato_x'][0]->field_value)){{$pdfdata['indeterminato_x'][0]->field_value}}@endif</td>
                <td>Data assunzione</td>
                <td>@if(!empty($pdfdata['data_assunzione'][0]->field_value)){{$pdfdata['data_assunzione'][0]->field_value}}@endif</td>
            </tr>
            <tr>
                <td>Ore settimanali</td>
                <td><b>@if(!empty($pdfdata['ore_settimanali'][0]->field_value)){{$pdfdata['ore_settimanali'][0]->field_value}}@endif</b></td>
                <td>Retribuzione mensile</td>
                <td><b>@if(!empty($pdfdata['retribuzione_mensile'][0]->field_value)){{$pdfdata['retribuzione_mensile'][0]->field_value}}@endif</b></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table>
            <tr>
                <td colspan='6'><b>SEDE LAVORO (se diverso dalla residenza del datore di lavoro)</b></td>
            </tr>
            <tr>
                <td>indirizzo</td>
                <td colspan='5'><b>@if(!empty($pdfdata['indirizzo_sede'][0]->field_value)){{$pdfdata['indirizzo_sede'][0]->field_value}}@endif</b></td>
            </tr>
            <tr>
                <td>Comune</td>
                <td><b>@if(!empty($pdfdata['comune_sede'][0]->field_value)){{$pdfdata['comune_sede'][0]->field_value}}@endif</b></td>
                <td>Provincia</td>
                <td><b>@if(!empty($pdfdata['provincia_sede'][0]->field_value)){{$pdfdata['provincia_sede'][0]->field_value}}@endif</b></td>
                <td>CAP</td>
                <td><b>@if(!empty($pdfdata['cap_sede'][0]->field_value)){{$pdfdata['cap_sede'][0]->field_value}}@endif</b></td>
            </tr>
        </table>
        <table>
            <tr>
                <td colspan='6'><b>Orario di lavoro</b></td>
            </tr>
            <tr>
                <td style='text-align: center;'><b>Lunedì</b></td>
                <td style='text-align: center;'><b>Martedì</b></td>
                <td style='text-align: center;'><b>Mercoledi</b></td>
                <td style='text-align: center;'><b>Giovedì</b></td>
                <td style='text-align: center;'><b>Venerdì</b></td>
                <td style='text-align: center;'><b>Sabato</b></td>
            </tr>
            <tr>
                <td style='text-align: center;'>@if(!empty($pdfdata['lunedi_dalle_mattina'][0]->field_value)){{$pdfdata['lunedi_dalle_mattina'][0]->field_value}}@endif</td>
                <td style='text-align: center;'>@if(!empty($pdfdata['martedi_dalle_mattina'][0]->field_value)){{$pdfdata['martedi_dalle_mattina'][0]->field_value}}@endif</td>
                <td style='text-align: center;'>@if(!empty($pdfdata['mercoledi_dalle_mattina'][0]->field_value)){{$pdfdata['mercoledi_dalle_mattina'][0]->field_value}}@endif</td>
                <td style='text-align: center;'>@if(!empty($pdfdata['giovedi_dalle_mattina'][0]->field_value)){{$pdfdata['giovedi_dalle_mattina'][0]->field_value}}@endif</td>
                <td style='text-align: center;'>@if(!empty($pdfdata['venerdi_dalle_mattina'][0]->field_value)){{$pdfdata['venerdi_dalle_mattina'][0]->field_value}}@endif</td>
                <td style='text-align: center;'>@if(!empty($pdfdata['sabato_dalle_mattina'][0]->field_value)){{$pdfdata['sabato_dalle_mattina'][0]->field_value}}@endif</td>
            </tr>
        </table>
        <br>
        <ul>
            <li>L'invio di comunicazioni telematiche agli enti competenti (INPS, INAIL, ecc.);</li>
            <li>La gestione delle buste paga;</li>
            <li>Il calcolo e versamento dei contributi previdenziali e assistenziali;</li>
            <li>La gestione delle pratiche fiscali connesse al rapporto di lavoro;</li>
            <li>Qualsiasi altra attività amministrativa relativa al rapporto di lavoro domestico.</li>
        </ul> 
        <p>
        La presente delega ha validità a partire dalla data di sottoscrizione e rimarrà in vigore fino a mia espressa
        revoca scritta.
        </p>
        <p><b>Firma del delegante (datore di lavoro):</b> ________________________</p>
        <p><b>Data: </b>______________________</p>
        <p><b>___________________________________________________________________________________</b></p>
        <p><b>Firma del delegato:</b> ____________________________</p>
        <p><b>Data:</b>__________________________________</p>
    </div>
</body>
</html>