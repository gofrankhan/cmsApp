<!DOCTYPE html>

<html>
<head>
<style>
div.main {
  margin-top: 20px;
  margin-bottom: 0px;
  margin-right: 5px;
  margin-left: 5px;
}
p, table {
  font-size: 14px;
}
</style>
    <title>Delega DSU</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="main">
      <h6 align="center">DELEGA/REVOCA PER L’ACCESSO<br>ALLA DICHIARAZIONE<br>DEI REDDITI PRECOMPILATA <br><br><br><br>IL SOTTOSCRITTO</h6>
      <br>
      <table>
          <tr>
              <td style="width:90px;">Codice fiscale<td>
              <td style="width:605px; border-bottom: 1px solid black;">{{ $customer->taxid}}</td>
          </tr>
      </table>
      <table>
          <tr>
              <td style="width:115px;">Cognome e Nome<td>
              <td style="width:580px; border-bottom: 1px solid black;">{{ $customer->lastname." ".$customer->firstname }}</td>
          </tr>
      </table>
      <table>
          <tr>
              <td style="width:155px;">Luogo e Data di nascita<td>
              <td style="width:350px; border-bottom: 1px solid black;">{{ $customer->citizenship }}</td>
              <td style="width:6px;">(<td>
              <td style="width:30px; border-bottom: 1px solid black; text-align:center">EE</td>
              <td style="width:6px;">)<td>
                @php
                $time=strtotime($customer->dateofbirth);
                $date1=date("d",$time);
                $month1=date("m",$time);
                $year1=date("Y",$time);
                @endphp
              <td style="width:30px; border-bottom: 1px solid black; text-align:center">{{ $date1 }}</td>
              <td style="width:6px;">/<td>
              <td style="width:30px; border-bottom: 1px solid black; text-align:center">{{ $month1 }}</td>
              <td style="width:6px;">/<td>
              <td style="width:50px; border-bottom: 1px solid black; text-align:center">{{ $year1 }}</td>
          </tr>
      </table>
      <table>
          <tr>
              <td style="width:135px;">Residenza: Comune<td>
              <td style="width:405px; border-bottom: 1px solid black;">{{ $customer->city }}</td>
              <td style="width:30px;">Prov<td>
              <td style="width:30px; border-bottom: 1px solid black; text-align:center">{{ $customer->region[0].$customer->region[1] }}</td>
              <td style="width:32px;">CAP<td>
              <td style="width:50px; border-bottom: 1px solid black; text-align:center">{{ $customer->postcode }}</td>
          </tr>
      </table>
      <table>
          <tr>
            <td style="width:55px;">Indirizzo<td>
            @php
                $words = explode(' ', $customer->addressline1);
                $last_word = array_pop($words);
                $address1 = join(" ", $words);
            @endphp
            @if($customer->addressline2 == '-')
            <td style="width:492px; border-bottom: 1px solid black;">{{ $address1}}</td>
            @else
            <td style="width:492px; border-bottom: 1px solid black;">{{ $address1." " .$customer->addressline2 }}</td>
            @endif
            <td style="width:90px;">Numero civico<td>
            <td style="width:50px; border-bottom: 1px solid black; text-align:center">{{ $last_word }}</td>
          </tr>
      </table>
      <br>
      <div style="width:680px;height:170px;border:1px solid #000;padding:10px;">
        <h6 align="center">IN QUALITÀ DI RAPPRESENTANTE/TUTORE DI<br>(DICHIARAZIONE DEI REDDITI DI PERSONA INCAPACE, COMPRESO IL MINORE)</h6>
        <table>
            <tr>
                <td style="width:90px;">Codice fiscale<td>
                <td style="width:585px; border-bottom: 1px solid black;"></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:115px;">Cognome e Nome<td>
                <td style="width:560px; border-bottom: 1px solid black;"></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:155px;">Luogo e Data di nascita<td>
                <td style="width:330px; border-bottom: 1px solid black;"></td>
                <td style="width:6px;">(<td>
                <td style="width:30px; border-bottom: 1px solid black; text-align:center"></td>
                <td style="width:6px;">)<td>
                <td style="width:30px; border-bottom: 1px solid black; text-align:center"></td>
                <td style="width:6px;">/<td>
                <td style="width:30px; border-bottom: 1px solid black; text-align:center"></td>
                <td style="width:6px;">/<td>
                <td style="width:50px; border-bottom: 1px solid black; text-align:center"></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:135px;">Residenza: Comune<td>
                <td style="width:385px; border-bottom: 1px solid black;"></td>
                <td style="width:30px;">Prov<td>
                <td style="width:30px; border-bottom: 1px solid black; text-align:center"></td>
                <td style="width:32px;">CAP<td>
                <td style="width:50px; border-bottom: 1px solid black; text-align:center"></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:55px;">Indirizzo<td>
                <td style="width:472px; border-bottom: 1px solid black;"></td>
                <td style="width:90px;">Numero civico<td>
                <td style="width:50px; border-bottom: 1px solid black; text-align:center"></td>
            </tr>
        </table>
      </div>
      <br>
      <table>
            <tr>
                <td style="width:20px;"><input type="checkbox" checked><td>
                <td style="width:230px; font-size: 12px;"><b>CONFERISCE DELEGA</b><td>
                <td style="width:20px;"><input type="checkbox"><td>
                <td style="width:270px; font-size: 12px;"><b>NON CONFERISCE DELEGA</b><td>
                <td style="width:20px;"><input type="checkbox"><td>
                <td style="width:230px; font-size: 12px;"><b>REVOCA DELEGA</b><td>
            </tr>
      </table>
        <br>
        <table>
            <tr>
                <p style="font-size: 12px;"><b>Al Centro di Assistenza Fiscale CAF UCI SRL - Cod. Fisc./P.Iva 04656741008 - numero di iscrizione all’albo <br> CAF 37 - con sede in ROMA (RM) in VIA IN LUCINA, 10 Cap 00186 - Codice fiscale del responsabile <br>dell’assistenza fiscale del CAF VLNFST67H10H501I</b></p>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:700px; font-size:12px;">All’accesso e alla consultazione della propria dichiarazione dei redditi precompilata e degli altri dati che l’Agenzia<td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:560px; font-size: 12px;">delle Entrate mette a disposizione ai fini della compilazione della dichiarazione relativa all’anno d’imposta</td>
                <td style="width:30px;height:10px;border:1px solid #000;padding-left:2px;padding-right:2px;font-size:10px;">{{ date("Y")-1 }}</td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="width:560px; font-size: 12px;">AUTORIZZA ad accedere all’archivio INPS:</td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:20px;"><input type="checkbox" checked><td>
                <td style="width:630px; font-size: 12px;"><b>CERTIFICAZIONE UNICA INPS  {{ date("Y") }}  REDDITI {{ date("Y")-1 }}</b><td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:20px;"><input type="checkbox" checked><td>
                <td style="width:630px; font-size: 12px;"><b>MATRICOLA RED  {{ date("Y") }}  E MATRICOLA RED SOLLECITO ANNI PRECEDENTI</b><td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:20px;"><input type="checkbox" checked><td>
                <td style="width:630px; font-size: 12px;"><b>MATRICOLA INVCIV  {{ date("Y") }}  E MATRICOLA INVCIV SOLLECITO ANNI PRECEDENTI</b><td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="width:290px;">Luogo e data<td>
                <td style="width:100px; font-size: 12px;"><td>
                <td style="width:290px;">Firma (per esteso e leggibile)<td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="width:290px; border-bottom: 1px solid black;">{{ $customer->city}}, {{date("d/m/Y")}}<td>
                <td style="width:100px; font-size: 12px;"><td>
                <td style="width:290px; border-bottom: 1px solid black;"><td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
               <td style="font-size: 12px;">- La delega può essere revocata in ogni momento presentando questo modello.</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size: 12px;">- Si allega fotocopia del documento di identità del delegante/revocante.</td> 
            </tr>
        </table>
        <br>
        <table>
            <tr>
               <td style="width:720px; font-size:12px; text-align:center;"><b>INFORMATIVA EX ARTICOLO 13 DEL D. LGS. 196 / 2003<b></td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;"><b>1. Tipologia dei dati<b></td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:9px; width:320px; border-bottom: 1px solid black;"><b>CAF UCI SRL- NAZIONALE<b></td> 
               <td style="font-size:10px;text-align:justify;">tratterà  i  dati  personali,  comuni  ed  eventualmente  sensibili,  funzionali</td> 
            </tr>
        </table>
        <table>
            <tr> 
               <td style="font-size:10px;text-align:justify;">all’accesso, consultazione e conservazione della dichiarazione dei redditi precompilata, messa a disposizione dall’Agenzia delle entrate, e di tutti i dati</td> 
            </tr>
        </table>
        <table>
            <tr> 
               <td style="font-size:10px;text-align:justify;">da questa resi disponibili per la compilazione della dichiarazione per l’anno d’imposta cui si riferisce la delega</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;"><b>2. Finalità del trattamento<b></td> 
            </tr>
        </table>
        
        <table>
            <tr>
               <td style="font-size:10px; width:190px; text-align:justify;">Il trattamento dei dati personali operato da</td> 
               <td style="font-size:9px; width:320px; border-bottom: 1px solid black;"><b>CAF UCI SRL- NAZIONALE<b></td> 
               <td style="font-size:10px; text-align:justify;"> è finalizzato all’accesso, consultazione</td> 
            </tr>
        </table>
        <table>
            <tr> 
               <td style="font-size:10px;text-align:justify;">e conservazione della dichiarazione dei redditi precompilata, messa a disposizione dall’Agenzia delle entrate, e di tutti i dati da questa resi disponibili</td> 
            </tr>
        </table>
        <table>
            <tr> 
               <td style="font-size:10px;text-align:justify;">per la compilazione della dichiarazione per l’anno d’imposta cui si riferisce la delega</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;"><b>3. Modalità del trattamento<b></td> 
            </tr>
        </table>
        
        <table>
            <tr>
               <td style="font-size:10px; text-align:justify;"> I dati personali verranno trattati sia manualmente che elettronicamente e saranno conservati sia in un archivio cartaceo sia nella banca dati elettronica a </td> 
            </tr>
        </table>
        <table>
            <tr> 
               <td style="font-size:10px;text-align:justify;">tal  uopo  predisposta  per  adempiere  agli  obblighi  e  alle  finalità  sopra  indicate.  I  dati  così  archiviati  saranno  trattati  utilizzando  le  misure  di  sicurezza</td> 
            </tr>
        </table>
        <table>
            <tr> 
               <td style="font-size:10px;text-align:justify;">prescritte dal D. Lgs. 196/03, in modo da ridurne al minimo i rischi di distruzione o perdita, di accesso non autorizzato o di trattamento non conforme</td> 
            </tr>
        </table>
        <table>
            <tr> 
               <td style="font-size:10px;text-align:justify;">alle finalità della raccolta</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;"><b>4. Ambito di comunicazione dei dati<b></td> 
            </tr>
        </table>
        <table>
            <tr> 
               <td style="font-size:10px;text-align:justify;">In relazione alle finalità sopra indicate i dati personali potranno essere comunicati alle seguenti categorie di soggetti:</td> 
            </tr>
        </table>
        <table>
            <tr> 
               <td style="width:5;"></td> 
               <td style="width:5;"></td> 
               <td style="font-size:10px; width:290px;text-align:justify;">centri servizi e professionisti che operano in nome e per conto di</td> 
               <td style="font-size:9px; width:380px; border-bottom: 1px solid black;"><b>CAF UCI SRL- NAZIONALE<b></td> 
            </tr>
        </table>
        <table>
            <tr> 
               <td style="width:5;"></td> 
               <td style="width:5;"></td> 
               <td style="font-size:10px; width:670px;text-align:justify;">regolarmente nominati responsabili del trattamento.</td>
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;"><b>5. Obbligo di conferire i dati<b></td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;">I dati strettamente necessari per realizzare la finalità di cui sopra sono quelli richiesti per il rilascio della relativa delega.</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;"><b>6. Diritti dell’interessato<b></td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;">In relazione al trattamento dei dati personali, il sottoscritto può esercitare, anche a mezzo delega o procura a persona fisica o associazione, i diritti ricono-</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;">sciutigli dall’art. 7 del D.Lgs. 196/2003, riportato in calce alla presente informativa rivolgendosi al titolare del trattamento</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;"><b>7. Titolare del trattamento <b></td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:150px;">Titolare del trattamento dei dati è </td> 
               <td style="font-size:9px; width:530px; border-bottom: 1px solid black;"><b>CAF UCI SRL- NAZIONALE</b></td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:85px;">con sede legale in</td> 
               <td style="font-size:9px; width:595px; border-bottom: 1px solid black;"><b>ROMA,VIA IN LUCINA10</b></td> 
            </tr>
        </table>

        <table>
            <tr>
               <td style="font-size:9px; width:680px; border-bottom: 1px solid black;">.</td> 
            </tr>
        </table>
        <br>
        <table>
            <tr>
               <td style="width:720px; font-size:12px; text-align:center;"><b>Art. 7. D. Lgs. 196/2003 “Diritto di accesso ai dati personali ed altri diritti”<b></td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:10px">1.</td>  
               <td style="font-size:10px;">L'interessato  ha  diritto  di  ottenere  la  conferma  dell'esistenza  o  meno  di  dati  personali  che  lo  riguardano,  anche  se  non  ancora  registrati,  e  la  loro </td> 
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size:10px;width:10px"></td> 
               <td style="font-size:10px;">comunicazione in forma intelligibile.</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:10px">2.</td>  
               <td style="font-size:10px;"> L'interessato ha diritto di ottenere l'indicazione:</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px">a)</td>  
               <td style="font-size:10px;">dell'origine dei dati personali;</td> 
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px">b)</td>  
               <td style="font-size:10px;">delle finalità e modalità del trattamento;</td> 
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px">c)</td>  
               <td style="font-size:10px;">della logica applicata in caso di trattamento effettuato con l'ausilio di strumenti elettronici;</td> 
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px">d)</td>  
               <td style="font-size:10px;">degli estremi identificativi del titolare, dei responsabili e del rappresentante designato ai sensi dell'articolo 5, comma 2;</td> 
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px">e)</td>  
               <td style="font-size:10px;">dei soggetti o delle categorie di soggetti ai quali i dati personali possono essere comunicati o che possono venirne a conoscenza in qualità di</td> 
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px"></td>  
               <td style="font-size:10px;">rappresentante designato nel territorio dello Stato, di responsabili o incaricati</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:10px">3.</td>  
               <td style="font-size:10px;"> L'interessato ha diritto di ottenere:</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px">a)</td>  
               <td style="font-size:10px;">l'aggiornamento, la rettificazione ovvero, quando vi ha interesse, l'integrazione dei dati;</td> 
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px">b)</td>  
               <td style="font-size:10px;">la cancellazione, la trasformazione in forma anonima o il blocco dei dati trattati in violazione di legge, compresi quelli di cui non è necessaria la</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px"></td>  
               <td style="font-size:10px;">conservazione in relazione agli scopi per i quali i dati sono stati raccolti o successivamente trattati;</td> 
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px">c)</td>  
               <td style="font-size:10px;">l'attestazione che le operazioni di cui alle lettere a) e b) sono state portate a conoscenza, anche per quanto riguarda il loro contenuto, di coloro ai </td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px"></td>  
               <td style="font-size:10px;">quali  i  dati  sono  stati  comunicati  o  diffusi,  eccettuato  il  caso  in  cui  tale  adempimento  si  rivela  impossibile  o  comporta  un  impiego  di  mezzi</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px"></td>  
               <td style="font-size:10px;">manifestamente sproporzionato rispetto al diritto tutelato.</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:10px">4.</td>  
               <td style="font-size:10px;">L'interessato ha diritto di opporsi, in tutto o in parte:</td> 
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px">a)</td>  
               <td style="font-size:10px;"> per motivi legittimi al trattamento dei dati personali che lo riguardano, ancorché pertinenti allo scopo della raccolta;</td> 
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px">b)</td>  
               <td style="font-size:10px;"> al trattamento di dati personali che lo riguardano a fini di invio di materiale pubblicitario o di vendita diretta o per il compimento di ricerche di</td> 
            </tr>
        </table>
        <table>
            <tr>
               <td style="font-size:10px;width:20px"></td> 
               <td style="font-size:10px;width:10px"></td>  
               <td style="font-size:10px;">mercato o di comunicazione commerciale.</td> 
            </tr>
        </table>
        <br>
        <table>
            <tr>
               <td style="width:720px; font-size:12px; text-align:center;"><b>CONSENSO AL TRATTAMENTODEI DATI PERSONALI<b></td> 
            </tr>
        </table>
        <p style="font-size:10px;">
            Presto il mio consenso al trattamento dei dati sensibili nei limiti delle operazioni strettamente necessarie per lo svolgimento della delega conferita, dichiarate nell’informativa ex articolo 13 del D. Lgs. 196/2003 
        </p>
        <table>
            <tr>
                <td style="width:290px;font-size:10px;">Luogo e data<td>
                <td style="width:100px; font-size: 12px;"><td>
                <td style="width:290px;font-size:10px;">Firma (per esteso e leggibile)<td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="width:290px; border-bottom: 1px solid black;font-size:10px;">{{ $customer->city}}, {{date("d/m/Y")}}<td>
                <td style="width:100px; font-size: 12px;"><td>
                <td style="width:290px; border-bottom: 1px solid black;"><td>
            </tr>
        </table>
    </div>
  </body>
</html>