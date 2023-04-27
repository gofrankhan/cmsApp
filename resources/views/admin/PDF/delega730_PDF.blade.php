<!DOCTYPE html>

<html>
<head>
<style>
div {
  margin-top: 20px;
  margin-bottom: 20px;
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
    <div>
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
    </div>
  </body>
</html>