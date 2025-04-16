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
    <h3>All User List</h3>

    <table width="100%">
        <thead style="background-color: green; color:#FFFFFF;">
            <tr class="font">
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Shop name</th>
                <th>Email</th>
                <th>User Type</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)
                <tr class="font">
                    <td align="center">{{ $user->id }}</td>
                    <td align="center">{{ $user->name }}</td>
                    <td align="center">{{ $user->username }}</td>
                    <td align="center">{{ $user->shop_name }}</td>
                    <td align="center">{{ $user->email }} </td>
                    <td align="center">{{ $user->user_type }} </td>
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
