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
    <title>Delega DSU</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div>
    <p><u>MODELLO A</u></p>
    <h4 align="center">Mandato al CAF</h4>
    <p align="center">(da compilare a cura del dichiarante della DSU, ai sensi del D.P.C.M. n. 159/2013, oppure del componente<br>
         nella sola ipotesi di sottoscrizione del modulo integrativo ai sensi dell’art. 3 del D.M.<br>
         del 7 novembre 2014).</p>
    <br><br><br>
    <table>
        <tr>
            <td style="width:115px;">Il/La sottoscritto/a<td>
            <td style="width:560px; border-bottom: 1px solid black;">{{ $customer->firstname." ".$customer->lastname }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width:56px;">nato/a a<td>
            <td style="width:240px; border-bottom: 1px solid black;">{{ $customer->citizenship }}</td>
            <td style="width:8px;">il<td>
            <td style="width:130px; border-bottom: 1px solid black;">{{ $customer->dateofbirth }}</td>
            <td style="width:24px;">C.F.<td>
            <td style="width:200px; border-bottom: 1px solid black;">{{ $customer->taxid }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width:75px;">residente in<td>
            <td style="width:600px; border-bottom: 1px solid black;">{{ $customer->city }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width:0px;"><td>
            <td style="width:675px; border-bottom: 1px solid black;">{{ $customer->addressline1." " .$customer->addressline2 }}</td>
        </tr>
    </table>
    </div>
</body>
</html>