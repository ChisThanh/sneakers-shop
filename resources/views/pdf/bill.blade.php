<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
    <style>
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 50px auto;
        }

        td,
        th {
            padding: 10px;
            text-align: left;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div>
        <center>
            <h1>Sneacker Shop</h1>
            <h2>Bill</h2>
        </center>

        <div style="margin-left: 25px;">
            <p>
                <b>Receiver</b>: {{ $data->user->name }}
                <br>
                <b>Email</b>: {{ $data->user->email }}
            </p>
        </div>
        <table class="table-main">
            <thead>
                <tr style="border-bottom: 1px black solid;">
                    <th style="text-align: center;"scope="col">No.</th>
                    <th scope="col">Description</th>
                    <th style="text-align: center;" scope="col">Price</th>
                    <th style="text-align: center;" scope="col">Quantity</th>
                    <th style="text-align: center;" scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->details as $key => $value)
                    <tr>
                        <th style="text-align: center;"scope="row">{{ $key + 1 }}</th>
                        <td>{{ $value->product_name }}</td>
                        <td style="text-align: center;">{{ $value->price }} VND</td>
                        <td style="text-align: center;">{{ $value->quantity }}</td>
                        <td style="text-align: center;">{{ $value->price * $value->quantity }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table>
            <tr>
                <td>
                    <h5>Contact Us</h5>
                    <ul>
                        <li>30 E Lake St, Chicago, USA</li>
                        <li>(510) 710-3464</li>
                        <li>info@worldcourse.com</li>
                    </ul>
                </td>
                <td>
                    <h5>Payment Info</h5>
                    <ul>
                        <li>Account No: </span> 102 3345 56938</li>
                        <li>Account Name: </span> William Peter</li>
                        <li>Branch Name: </span> XYZ </li>
                    </ul>
                </td>
            </tr>
        </table>

    </div>
</body>

</html>
