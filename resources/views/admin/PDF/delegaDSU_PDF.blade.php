<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 Generate PDF Example - ItSolutionStuff.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>(da compilare a cura del dichiarante della DSU, ai sensi del D.P.C.M. n. 159/2013, oppure del componente
         nella sola ipotesi di sottoscrizione del modulo integrativo ai sensi dell’art. 3 del D.M.del
          7 novembre 2014).</p>
  
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last Name</th>
        </tr>
        <tr>
            <td>{{ $customer->id }}</td>
            <td>{{ $customer->firstname }}</td>
            <td>{{ $customer->lastname }}</td>
        </tr>
    </table>
  
</body>
</html>