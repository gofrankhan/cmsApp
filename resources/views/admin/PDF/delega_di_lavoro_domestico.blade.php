<!DOCTYPE html>

<html>
<head>
<style>
div {
  margin-top: 20px;
  margin-bottom: 20px;
  margin-right: 10px;
  margin-left: 10px;
}
p, table {
  font-size: 14px;
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
        <h5 style="text-align:center">Delega per la gestione del rapporto di lavoro domestico</h5>
        <br>
        Io sottoscritto @if(!empty($pdfdata['nome'][0]->field_value)){{$pdfdata['nome'][0]->field_value}}@endif
        @if(!empty($pdfdata['cognome'][0]->field_value)){{$pdfdata['cognome'][0]->field_value}}@endif
        , nato/a a @if(!empty($pdfdata['luogo_di_nascita'][0]->field_value)){{$pdfdata['luogo_di_nascita'][0]->field_value}}@endif il 
        @if(!empty($pdfdata['data_di_nascita'][0]->field_value)){{$pdfdata['data_di_nascita'][0]->field_value}}@endif , residente in 
        @if(!empty($pdfdata['indirizzo'][0]->field_value)){{$pdfdata['indirizzo'][0]->field_value}}@endif , codice fiscale
        {{$customer->taxid}}
        <br>
        <br>
        in qualità di datore di lavoro domestico del/la Sig./Sig.ra {{ $customer->firstname }} {{ $customer->lastname }} 
        , nato/a a {{ $customer->pob }}  il {{ $date1."/".$month1."/".$year1; }} , residente in {{ $customer->addressline1 }} {{ $customer->addressline2 }} 
        , codice fiscale {{$customer->taxid}}
        <br>
        <br>
        con riferimento al contratto di lavoro domestico di tipo @if(!empty($pdfdata['indeterminato_x'][0]->field_value)){{$pdfdata['indeterminato_x'][0]->field_value}}@endif
        , con decorrenza dal @if(!empty($pdfdata['data_assunzione'][0]->field_value)){{$pdfdata['data_assunzione'][0]->field_value}}@endif
        , avente come sede di lavoro @if(!empty($pdfdata['indirizzo_sede'][0]->field_value)){{$pdfdata['indirizzo_sede'][0]->field_value}}@endif
        <br>
        <br>
        DELEGO
        <br>
        <br>
        il/la Sig./Sig.ra ra POPY CHAKRABORTY, nato/a a CUMILLA (BGD) il 02/01/1992, codice fiscale
        CHKPPY92A42Z249O, residente in ROMA, PIAZZA SAN GIOVANNI BOSCO 5,
        <br>
        <br>
        a gestire per mio conto tutte le attività connesse al rapporto di lavoro con il/la Sig./Sig.ra {{ $customer->firstname }} {{ $customer->lastname }}
        , inclusi, ma non limitati a, i seguenti compiti:
        <br>
        <br>
        <ul>
            <li>L'invio di comunicazioni telematiche agli enti competenti (INPS, INAIL, ecc.);</li>
            <li>La gestione delle buste paga;</li>
            <li>Il calcolo e versamento dei contributi previdenziali e assistenziali;</li>
            <li>La gestione delle pratiche fiscali connesse al rapporto di lavoro;</li>
            <li>Qualsiasi altra attività amministrativa relativa al rapporto di lavoro domestico.</li>
        </ul> 
        <br>
        La presente delega ha validità a partire dalla data di sottoscrizione e rimarrà in vigore fino a mia espressa
        revoca scritta.
        <br>
        <br>
        <b>Firma del delegante (datore di lavoro):</b> ________________________
        <br>
        <br>
        <b>Data: </b>______________________
        <br>
        <br>
        <p><b>___________________________________________________________________________________</b></p>
        <br>
        <br>
        <b>Firma del delegato:</b> ____________________________
        <br>
        <br>
        <b>Data:</b> __________________________________
    </div>
</body>
</html>