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
    <title>Delega Domanda Flussi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="abcdx"> 
        <h5 align="center"><b>DELEGA INVIO DOMANDA FLUSSI IMMIGRATORI</b></h5>
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
                </td>
            </tr>
        </table>
        <br>
        <h5 align="center"><b>DELEGO</b></h5>
        <table>
            <tr>
                <td style="text-align:justify">
                L'ASSOCIAZIONE "UCI ZONALE TUSCOLANO STILICONE" 
                Con sede legale a ROMA in VIA FLAVIO STILICONE 11, 00175 con C.F. E PARTITA IVA -  16960031009,
                </td>
            <tr>
            <tr>
                <td style="text-align:justify">
                per la richiesta dei flussi immigratori per il lavoratore straniero Sig./ra 
                @if(!empty($pdfdata['nome'][0]->field_value)){{$pdfdata['nome'][0]->field_value}}@endif
                @if(!empty($pdfdata['cognome'][0]->field_value)){{$pdfdata['cognome'][0]->field_value}}@endif
                per conto del sottoscritto con le seguenti indicazioni
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
                <td>Luogo e data {{ $customer->city }} ___/___/______</td>
                <td style="width:240px"> </td>
                <td align="right">Firma _________________</td>
            </tr>
        </table>
        <br>
        <p style="font-size: 10px;" align='center'>DICHIARAZIONE DI CONSENSO AL TRATTAMENTO DEI DATI SENSIBILI</p>
        <p style="font-size: 10px;">
        Io sottoscritto/a {{ $customer->firstname." ".$customer->lastname }}, dichiaro di avere ricevuto le informazioni di cui all'art. 13 del D.lgs. 196/2003 
        in particolare riguardo ai diritti da me riconosciuti dalla legge ex art. 7 D.lgs. 196/2003, acconsento al trattamento dei miei 
        dati personali e sensibili, con le modalità e per le finalità indicate nella informativa stessa, comunque, 
        strettamente connesse e strumentali alla gestione dell'attività di "INVIO DOMANDA FLUSSI IMMIGRATORI" del 
        L'ASSOCIAZIONE UCI ZONALE TUSCOLANO STILICONE E 
        </p>
        <table>
            <tr>
                <td>Luogo e data {{ $customer->city }} ___/___/______</td>
                <td style="width:240px"> </td>
                <td align="right">Firma _________________</td>
            </tr>
        </table>
        <br>
        <p style="font-size: 10px;" align='center'>INFORMATIVA EX ART.13 D.LGS. 196/2003</p>
        <p style="font-size: 10px;">
        Gentile Signora/e, desideriamo informarLa che il D.lgs. n. 196 del 30 giugno 2003 
        ("Codice in materia di protezione dei dati personali"), prevede la tutela delle persone e di altri soggetti rispetto 
        al trattamento dei dati personali. Secondo la normativa indicata, tale trattamento sarà improntato ai principi di correttezza, 
        liceità e trasparenza e di tutela della Sua riservatezza e dei Suoi diritti. Ai sensi dell'art.13 d.lgs.196/2003 il 
        L'ASSOCIAZIONE UCI ZONALE TUSCOLANO STILICONE E  è tenuto a fornirLe alcune informazioni relative all'utilizzo dei dati personali e sensibili 
        da Lei forniti o comunque dallo stesso acquisiti anche in futuro, nel corso della durata dei servizi connessi all'attività 
        del L'ASSOCIAZIONE UCI ZONALE TUSCOLANO STILICONE E. 1. FINALITA' E MODALITA' DEL TRATTAMENTO CUI SONO DESTINATI I DATI. Il trattamento dei dati da Lei 
        forniti avviene mediante strumenti manuali, informatici e telematici. I dati saranno trattati nel rispetto delle regole di 
        riservatezza e sicurezza previsti dalla legge ed avranno il solo fine di consentire la raccolta dei documenti di supporto 
        necessaria all'attività professionale da parte del L'ASSOCIAZIONE UCI ZONALE TUSCOLANO STILICONE E . Il trattamento dei dati potrebbe riguardare anche 
        categorie di dati definiti "sensibili" da Lei forniti. 2. NATURA OBBLIGATORIA DEL CONFERIMENTO DEI DATI E CONSEGUENZE DI UN EVENTUALE RIFIUTO DI RISPONDERE.
        I dati da Lei conferiti hanno natura obbligatoria per poter effettuare le operazioni di cui al punto 1. La mancata accettazione ed 
        autorizzazione all'utilizzo dei dati comporta l'impossibilità per il L'ASSOCIAZIONE UCI ZONALE TUSCOLANO STILICONE E  di procedere alla fornitura del 
        servizio. 3. AMBITO DI COMUNICAZIONE E DIFFUSIONE. I Suoi dati potranno essere comunicati al personale dipendente incaricato del
        trattamento per finalità funzionali all'attività del L'ASSOCIAZIONE UCI ZONALE TUSCOLANO STILICONE E . Si informa, inoltre, che i dati necessari per 
        l'attività professionale saranno raccolti da aziende connesse alla L'ASSOCIAZIONE UCI ZONALE TUSCOLANO STILICONE E . 4. DIRITTI DELL'INTERESSATO. L'art.7 
        del d.lgs.196/2003 Le attribuisce, in quanto soggetto interessato, i seguenti diritti: a) ottenere la conferma dell'esistenza dei 
        Suoi dati personali, anche se non ancora registrati e la loro comunicazione in forma intelligibile. b) l'indicazione dell'origine 
        dei dati personali, della finalità e modalità del loro trattamento; della logica applicata in caso di trattamento effettuato con 
        l'ausilio di strumenti elettronici; degli estremi identificativi del titolare, del responsabile e dei soggetti o categorie di 
        soggetti ai quali i dati possono essere comunicati o che possono venirne a conoscenza in qualità di responsabile o incaricato. 
        c) ottenere l'aggiornamento, la rettifica o l'integrazione dei dati; la loro cancellazione, la trasformazione in forma anonima o 
        il blocco dei dati trattati in violazione di legge; l'attestazione che tali operazioni sono state portate a conoscenza degli 
        eventuali soggetti cui i dati sono stati comunicati o diffusi. d) opporsi al trattamento dei Suoi dati personali in presenza di 
        giustificati motivi o nel caso in cui gli stessi siano utilizzati per fini diversi da quelli elencati al punto 1. e) il 
        L'ASSOCIAZIONE UCI ZONALE TUSCOLANO STILICONE E  non si assume alcuna responsabilità in ordine alla veridicità dei dati personali inseriti e ricevuti 
        dall'interessato che, s'intende, ne rimane responsabile unico. 5. ESTREMI IDENTIFICATIVI DEL TITOLARE E' titolare del trattamento 
        dei Suoi dati, secondo quanto previsto dal D. Lgs. n. 196 del 2003, il L'ASSOCIAZIONE UCI ZONALE TUSCOLANO STILICONE E . Avendo ricevuto l'informativa 
        sul trattamento dei dati personali ex art. 13 del D.Lgs. n. 196/2003 
        - acconsento inoltre al trattamento ed alla comunicazione dei dati personali ad aziende connesse direttamente o indirettamente, 
        dei miei dati a fini promozionali, di informazione commerciale, ricerche di mercato, offerte di prodotti e servizi. 
        
        </p>
    </div>
</body>
</html>