<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

        .font {
            font-size: 10px;
        }

        .authority {
            /*text-align: center;*/
            float: right
        }

        .authority h5 {
            margin-top: -10px;
            color: green;
            /*text-align: center;*/
            margin-left: 35px;
        }

        .thanks p {
            color: green;
            ;
            font-size: 16px;
            font-weight: normal;
            font-family: serif;
            margin-top: 20px;
        }
    </style>

</head>

<body>
    <h3>Admin Movement File List</h3>

    <table width="100%">
        <thead style="background-color: green; color:#FFFFFF;">
            <tr class="font">
                <th>File Id</th>
                <th>Customer Name</th>
                <th>Description</th>
                <th>Shop Name</th>
                <th>Service</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($movements as $movement)
                <tr class="font">
                    <td align="center">{{ $movement->file_id }}</td>
                    <td align="center">{{ $movement->customer }}</td>
                    <td align="center">{{ $movement->description }}</td>
                    <td align="center">{{ $movement->shop }} </td>
                    <td align="center">{{ $movement->service }} </td>
                    <td align="center">{{ $movement->amount }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <br>
    <div class="authority float-right mt-5">
        <p>-----------------------------------</p>
        <h5>Authority Signature:</h5>
    </div>
</body>

</html>
