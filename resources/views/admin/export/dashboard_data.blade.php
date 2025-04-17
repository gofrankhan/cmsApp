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
            font-size: 9px;
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
    <h3>Transaction Summary</h3>

    <table width="100%">
        <thead style="background-color: green; color:#FFFFFF;">
            <tr class="font">
                <th>Shop Name</th>
                <th>Balance</th>
                <th>Due</th>
                <th>Transactions</th>
                <th>Paid</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($totalInvoiceByShop as $invoice)
                <tr >
                    <td align="center">{{$invoice->shop_name}}</td>
                @if($invoice->total_invoice < 0)
                <td align="center">{{ -$invoice->total_invoice}}</td>
                <td align="center">----</td>
                @else
                <td align="center">----</td>
                <td align="center">{{$invoice->total_invoice}}</td>
                @endif
                <td align="center">{{$invoice->positive_sum}}</td>
                <td align="center">{{$invoice->negative_sum}}</td>
                <td align="center">{{$invoice->count}}</td>
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
