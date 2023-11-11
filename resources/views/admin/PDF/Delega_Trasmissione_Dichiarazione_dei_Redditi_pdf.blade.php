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

p {
  font-size: 10px;
}
table, td, tr {
    font-size : 10px;
}

table.small9, td, tr {
    font-size : 9.5px;
}

</style>
    <title>Delega Trasmissione Dichiarazione dei Redditi pdf</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
@php
    $date_today = date("d/m/Y");
@endphp
<body>
    <div class="nwew23">   
        <div align="center">
            <img  src="{{ asset('backend/assets/images/PCPoint_Logo.png') }}" height="100" width="500"  alt="">
        </div>  
        </div>
        <p align="center" style="font-size:12px;">VIA FLAVIO STILCIONE 11, 00175, ROMA (RM)<br>
        Tel- 06 8788 0399, email- <u>cafpcpoint@yahoo.com</u>, pec- <u>cafpcpoint@pec.it</p>
        <p align="center"><b>DELEGA TRASMISSIONE DICHIARAZIONE DEI REDDITI</b></p>
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
                <td style="width:79px;">La/Il sottoscritta/o<td>
                <td style="width:200px; border-bottom: 0.5px solid black;">{{ $customer->firstname." ".$customer->lastname }}</td>
                <td style="width:38px;"> nata/o il<td>
                <td style="width:120px; border-bottom: 0.5px solid black;">{{ $date1."/".$month1."/".$year1; }}</td>
                <td style="width:61px;"> codice fiscale<td>
                <td style="width:200px; border-bottom: 0.5px solid black;">{{ $customer->taxid }}</td>
            </tr>
        </table>
        <table style="padding-top:10px">
            <tr>
                <td style="width:61px;">tel. Cellulare:<td>
                <td style="width:140px; border-bottom: 0.5px solid black;">{{ $customer->mobile }}</td>
                <td style="width:50px;">residente a<td>
                <td style="width:70px; border-bottom: 0.5px solid black;">{{ $customer->city }}</td>
                <td style="width:60px;"> in Via/Piazza<td>
                <td style="width:200px; border-bottom: 0.5px solid black;">{{ $customer->addressline1 }}</td>
                <td style="width:20px;">Prov.<td>
                <td style="width:30px; border-bottom: 0.5px solid black;">@if(!empty($customer->region)){{ $customer->region[0].$customer->region[1] }}@endif</td>
                <td style="width:20px;">CAP<td>
                <td style="width:30px; border-bottom: 0.5px solid black;">{{ $customer->postcode }}</td>
            </tr>
        </table>
        <br>
        <p align="center"><b>DELEGO</b></p>
        <table>
            <tr>
                <td>"CHAKRABORTY NIBASH TITOLARE CAF PC POINT" con sede legale a ROMA in Via Flavio Stilicone, 11 con p.Iva 15865031007, alla trasmissione della</td>
            </tr>
        </table>
        <table>
            <tr>
                <td>ichiarazione dei redditi per il l'anno fiscale ANNO</td>
                <td style="width:40px;">@if(!empty($pdfdata['anno'][0]->field_value)){{$pdfdata['anno'][0]->field_value}}@endif</td>
                <td>RIF</td>
                <td style="width:60px;">@if(!empty($pdfdata['rif'][0]->field_value)){{$pdfdata['rif'][0]->field_value}}@endif</td>
                <td>per il dichiarante con codice fiscale: </td>
                <td >{{ $customer->taxid }}</td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td>Luogo e data ROMA</td>
                <td style="width:50px; border-bottom: 0.5px solid black;">{{ $date_today}}</td>
                <td style="width:414px;"></td>
                <td>Firma______________________</td>
            </tr>
        </table>
        <br>
        <p align="center" style="font-size:12px;">DICHIARAZIONE DI CONSENSO AL TRATTAMENTO DEI DATI SENSIBILI</p>
        <table class="small9">
            <tr>
                <td style="width:64px;">lo sottoscritto/a<td>
                <td style="width:200px; border-bottom: 0.5px solid black;">{{ $customer->firstname." ".$customer->lastname }}</td>
                <td style="width:38px;"> nato/a il<td>
                <td style="width:120px; border-bottom: 0.5px solid black;">{{ $customer->citizenship }}</td>
                <td style="width:61px;"> codice fiscale<td>
                <td style="width:210px; border-bottom: 0.5px solid black;">{{ $customer->taxid }}</td>
            </tr>
        </table>
        <table class="small9">
            <tr>
                <td>dichiaro di avere ricevuto le informazioni di cui all'art. 13 del D.lgs. 196/2003 in particolare riguardo ai diritti da me riconosciuti dalla legge ex art. 7 D.lgs.<td>
            </tr>
        </table>
        <table class="small9">
            <tr>
                <td>196/2003, acconsento al trattamento dei miei dati personali e sensibili, con le modalità e per le finalità indicate nella informativa stessa, comunque, strettamente<td>
            </tr>
        </table>
        <table class="small9">
            <tr>
                <td>connesse e strumentali alla gestione dell'attività di "Servizi di studi legali" del caf pc point.<td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="font-size : 12px;"><b>ai sensi e per gli effetti degli artt. 13 e 23 del D. L.gs. n. 196/2003, con la sottoscrizione del presente modulo, al</b><td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size : 12px;"><b>trattamento dei dati personali secondo le modalità e nei limiti di cui all’informativa allegata.</b><td>
            </tr>
        </table>
        <br>
        <p align="center" style="font-size:12px;">INFORMATIVA EX ART.13 D.LGS. 196/2003</p>
        <p align="left" style="font-size:9.5px;">
            Gentile Signora/e, desideriamo informarla che il D.lgs. n. 196 del 30 giugno 2003 ("Codice in materia di protezione dei dati
            personali"), prevede la tutela delle persone e di altri soggetti rispetto al trattamento dei dati personali. Secondo la
            normativa indicata, tale trattamento sarà improntato ai principi di correttezza, liceità e trasparenza e di tutela della
            Sua riservatezza e dei Suoi diritti. Ai sensi dell'art.13 d.lgs.196/2003 il  CHAKRABORTY NIBASH E {{ $user->shop_name}} è tenuto a fornirle alcune
            informazioni relative all'utilizzo dei dati personali e sensibili da Lei forniti o comunque dallo stesso acquisiti anche
            in futuro, nel corso della durata dei servizi connessi all'attività del CHAKRABORTY NIBASH E {{ $user->shop_name}}. 1. FINALITA' E MODALITA' DEL
            TRATTAMENTO CUI SONO DESTINATI I DATI. Il trattamento dei dati da Lei forniti avviene mediante strumenti manuali,
            informatici e telematici. I dati saranno trattati nel rispetto delle regole di riservatezza e sicurezza previsti dalla
            legge ed avranno il solo fine di consentire la raccolta dei documenti di supporto necessaria all'attività professionale
            da parte del  CHAKRABORTY NIBASH E {{ $user->shop_name}}. Il trattamento dei dati potrebbe riguardare anche categorie di dati definiti 
            "sensibili" da Lei forniti. 2. NATURA OBBLIGATORIA DEL CONFERIMENTO DEI DATI E CONSEGUENZE DI UN EVENTUALE 
            RIFIUTO DI RISPONDERE. I dati da Lei conferiti hanno natura obbligatoria per poter effettuare le operazioni 
            di cui al punto 1. La mancata accettazione ed autorizzazione all'utilizzo dei dati comporta l'impossibilità 
            per il  CHAKRABORTY NIBASH E {{ $user->shop_name}} di procedere alla fornitura del servizio. 3. AMBITO DI COMUNICAZIONE E DIFFUSIONE. 
            I Suoi dati potranno essere comunicati al personale dipendente incaricato del trattamento per finalità funzionali 
            all'attività del  CHAKRABORTY NIBASH E {{ $user->shop_name}}. Si informa, inoltre, che i dati necessari per l'attività professionale saranno 
            raccolti da aziende, collaboratori e professionisti connesse alla  CHAKRABORTY NIBASH E {{ $user->shop_name}}. 4. DIRITTI DELL'INTERESSATO. 
            L'art.7 del d.lgs.196/2003 Le attribuisce, in quanto soggetto interessato, i seguenti diritti: a) ottenere la conferma 
            dell'esistenza dei Suoi dati personali, anche se non ancora registrati e la loro comunicazione in forma intelligibile. 
            b) l'indicazione dell'origine dei dati personali, della finalità e modalità del loro trattamento; della 
            logica applicata in caso di trattamento effettuato con l'ausilio di strumenti elettronici; degli estremi 
            identificativi del titolare, del responsabile e dei soggetti o categorie di soggetti ai quali i dati possono 
            essere comunicati o che possono venirne a conoscenza in qualità di responsabile o incaricato. c) ottenere 
            l'aggiornamento, la rettifica o l'integrazione dei dati; la loro cancellazione, la trasformazione in forma anonima o il 
            blocco dei dati trattati in violazione di legge; l'attestazione che tali operazioni sono state portate a conoscenza 
            degli eventuali soggetti cui i dati sono stati comunicati o diffusi. d) opporsi al trattamento dei Suoi dati personali 
            in presenza di giustificati motivi o nel caso in cui gli stessi siano utilizzati per fini diversi da quelli elencati al 
            punto 1. e) il  CHAKRABORTY NIBASH E {{ $user->shop_name}} non si assume alcuna responsabilità in ordine alla veridicità dei dati personali 
            inseriti e ricevuti dall'interessato che, s'intende, ne rimane responsabile unico. 5. ESTREMI IDENTIFICATIVI DEL 
            TITOLARE E' titolare del trattamento dei Suoi dati, secondo quanto previsto dal D. Lgs. n. 196 del 2003, il  
            CHAKRABORTY NIBASH E {{ $user->shop_name}}. Avendo ricevuto l'informativa sul trattamento dei dati personali ex art. 13 del d.lgs. n. 
            196/2003 - acconsento inoltre al trattamento ed alla comunicazione dei dati personali ad aziende connesse direttamente 
            o indirettamente, dei miei dati a fini promozionali, di informazione commerciale, ricerche di mercato, offerte di 
            prodotti e servizi.
        </p>
        <br>
        <table>
            <tr>
                <td>Luogo e data ROMA</td>
                <td style="width:50px; border-bottom: 0.5px solid black;">{{ $date_today}}</td>
                <td style="width:414px;"></td>
                <td>Firma______________________</td>
            </tr>
        </table>
    </div>
</body>
</html>