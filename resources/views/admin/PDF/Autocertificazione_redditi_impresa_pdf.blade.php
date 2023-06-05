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
    <div>
        <div align="center" padding="0px">
            <img  src="{{ public_path('backend/assets/images/PCPoint_Logo.png') }}" height="100" width="500" alt="">
        </div>  
        <p align="center">VIA FLAVIO STILCIONE 11, 00175, ROMA (RM)<br>
        Tel- 06 8788 0399, email- <u>cafpcpoint@yahoo.com</u>, pec- <u>cafpcpoint@pec.it</u></p>
        <h5><b>AUTOCERTIFICAZIONE DEL REDDITO DI LAVORO AUTONOMO</b></h5>

        <table>
            <tr>
                <td style="width:115px;">Il/La sottoscritto/a<td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:56px;">nato a<td>
                <td style="width:240px;"></td>
                <td style="width:8px;">il<td>
                <td style="width:200px;"></td>
                <td style="width:85px;">e residente a<td>
                <td style="width:55px;"></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:56px;">in via<td>
                <td style="width:400px;"></td>
                <td style="width:16px;">n<sup>o</sup><td>
                <td style="width:100px;"></td>
                <td style="width:85px;">prov<td>
                <td style="width:55px;"></td>
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
    </div>
</body>
</html>