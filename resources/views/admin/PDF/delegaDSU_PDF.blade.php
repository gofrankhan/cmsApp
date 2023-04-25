<!DOCTYPE html>

<html>
<head>
<style>
div {
  margin-top: 100px;
  margin-bottom: 100px;
  margin-right: 150px;
  margin-left: 80px;
}
p, table {
  font-size: 28px;
}
</style>
    <title>Laravel 9 Generate PDF Example - ItSolutionStuff.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div>
    <p><u>MODELLO A</u></p>
    <h1 align="center">Mandato al CAF</h1>
    <p>01/01/2023</p>
    <p align="center">(da compilare a cura del dichiarante della DSU, ai sensi del D.P.C.M. n. 159/2013, oppure del componente<br>
         nella sola ipotesi di sottoscrizione del modulo integrativo ai sensi dell’art. 3 del D.M.del<br>
          7 novembre 2014).</p>
    <br><br><br>
    <table>
        <tr>
            <td style="width:15%;">Il/La sottoscritto/a<td>
            <td style="width:100%; border-bottom: 2px solid black;">{{ $customer->firstname." ".$customer->lastname }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width:7%;">nato/a a<td>
            <td style="width:40%; border-bottom: 2px solid black;">{{ $customer->citizenship }}</td>
            <td style="width:1%;">il<td>
            <td style="width:17%; border-bottom: 2px solid black;">{{ $customer->dateofbirth }}</td>
            <td style="width:3%;">C.F.<td>
            <td style="width:32%; border-bottom: 2px solid black;">{{ $customer->taxid }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width:10%;">residente in<td>
            <td style="width:100%; border-bottom: 2px solid black;">{{ $customer->city }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width:0%;"><td>
            <td style="width:100%; border-bottom: 2px solid black;">{{ $customer->addressline1." " .$customer->addressline2 }}</td>
        </tr>
    </table>
    </div>
</body>
</html>