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
            font-size: 5px;
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
    <h3>All Customer List</h3>

    <table width="100%">
        <thead style="background-color: green; color:#FFFFFF;">
            <tr class="font">
                <th>ID</th>
                <th>Tax ID</th>
                <th>Type</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Mobile</th>
                <th>Date of Birth</th>
                <th>Place of Birth</th>
                <th>Citizenship</th>
                <th>Address Line 1</th>
                <th>City</th>
                <th>Region</th>
                <th>PostCode</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($customers as $customer)
                <tr class="font">
                    <td align="center">{{ $customer->id }}</td>
                    <td align="center">{{ $customer->taxid }}</td>
                    <td align="center">{{ $customer->customertype }}</td>
                    <td align="center">{{ $customer->firstname }} </td>
                    <td align="center">{{ $customer->lastname }} </td>
                    <td align="center">{{ $customer->mobile }}</td>
                    <td align="center">{{ $customer->dateofbirth }}</td>
                    <td align="center">{{ $customer->pob }}</td>
                    <td align="center">{{ $customer->citizenship }}</td>
                    <td align="center">{{ $customer->addressline1 }} </td>
                    <td align="center">{{ $customer->city }} </td>
                    <td align="center">{{ $customer->region }} </td>
                    <td align="center">{{ $customer->postcode }} </td>
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
