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
              <td style="width:30px; border-bottom: 1px solid black; text-align:center">01</td>
              <td style="width:6px;">/<td>
              <td style="width:30px; border-bottom: 1px solid black; text-align:center">09</td>
              <td style="width:6px;">/<td>
              <td style="width:50px; border-bottom: 1px solid black; text-align:center">1989</td>
          </tr>
      </table>
      <table>
          <tr>
              <td style="width:135px;">Residenza: Comune<td>
              <td style="width:405px; border-bottom: 1px solid black;">{{ $customer->city }}</td>
              <td style="width:30px;">Prov<td>
              <td style="width:30px; border-bottom: 1px solid black; text-align:center"></td>
              <td style="width:32px;">CAP<td>
              <td style="width:50px; border-bottom: 1px solid black; text-align:center"></td>
          </tr>
      </table>
      <table>
          <tr>
              <td style="width:55px;">Indirizzo<td>
              <td style="width:492px; border-bottom: 1px solid black;">{{ $customer->addressline1." " .$customer->addressline2  }}</td>
              <td style="width:90px;">Numero civico<td>
              <td style="width:50px; border-bottom: 1px solid black; text-align:center"></td>
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
                <td style="width:30px;height:10px;border:1px solid #000;padding-left:2px;padding-right:2px;font-size:10px;">2022</td>
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
                <td style="width:630px; font-size: 12px;"><b>CERTIFICAZIONE UNICA INPS  2023  REDDITI 2022</b><td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:20px;"><input type="checkbox" checked><td>
                <td style="width:630px; font-size: 12px;"><b>MATRICOLA RED  2023  E MATRICOLA RED SOLLECITO ANNI PRECEDENTI</b><td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:20px;"><input type="checkbox" checked><td>
                <td style="width:630px; font-size: 12px;"><b>MATRICOLA INVCIV  2023  E MATRICOLA INVCIV SOLLECITO ANNI PRECEDENTI</b><td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="width:320px;">Luogo e data<td>
                <td style="width:100px; font-size: 12px;"><td>
                <td style="width:320px;">Firma (per esteso e leggibile)<td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="width:320px; border-bottom: 1px solid black;">ROMA, 14/04/2023<td>
                <td style="width:100px; font-size: 12px;"><td>
                <td style="width:320px; border-bottom: 1px solid black;"><td>
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
    </div>
  </body>
</html>