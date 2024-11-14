<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Bill</title>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }

        /* Receipt container */
        #receipt {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        /* Top section (header) */
        #top .info {
            text-align: center;
        }

        #top h2 {
            margin: 0;
            font-size: 2em;
            color: #007bff;
        }

        #top p {
            font-size: 0.9em;
            color: #555;
            margin: 5px 0;
            line-height: 1.5;
        }

        /* Button styling */
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin: 10px;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        #button-group {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            vertical-align: middle;
        }

        table th {
            background-color: #f0f2f5;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        table td {
            font-size: 0.9em;
        }

        .service td {
            background-color: #fafafa;
        }

        .total-row td {
            font-weight: bold;
            color: #007bff;
            font-size: 1em;
        }

        /* Footer message */
        #legalcopy {
            margin-top: 20px;
            font-size: 0.9em;
            text-align: center;
            color: #555;
            line-height: 1.5;
        }

        .legal strong {
            color: #333;
        }

        .rate {
            font-weight: bold;
            text-align: right;
        }

        .payment {
            color: #28a745; /* Green for prices */
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('pembelian.download_pdf', $order['id']) }}" class="btn">Download PDF</a>
    </div>

    <div id="receipt">
        <center id="top">
            <div class="info">
                <h2>Apotek Kimia Farma</h2>
                <p>
                    Alamat: Sepanjang Jalan Kenangan <br>
                    Email: apotekkimiafarma@gmail.com <br>
                    Phone: 000-111-222
                </p>
            </div>
        </center>

        <div id="table">
            <table>
                <tr class="tabletitle">
                    <th class="name">Customer</th>
                    <th class="item">Obat</th>
                    <th class="quantity">Jumlah</th>
                    <th class="rate">Harga</th>
                </tr>
                @foreach ($order['medicines'] as $medicine)
                    <tr class="service">
                        <td class="tableitem">{{ $order['name_customer'] }}</td>
                        <td class="tableitem">{{ $medicine['medicines'] }}</td>
                        <td class="tableitem">{{ $medicine['quantity'] }}</td>
                        <td class="tableitem">Rp.{{ number_format($medicine['price'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="tabletitle">
                    <td colspan="2" class="rate">PPN (10%)</td>
                    @php
                        $ppn = $order['total_price'] * 0.1;
                    @endphp
                    <td class="payment">Rp.{{ number_format($ppn, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2" class="rate">Total</td>
                    <td class="payment">Rp.{{ number_format($order['total_price'] + $ppn, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div id="legalcopy">
            <p class="legal">
                <strong>Terimakasih atas pembelian Anda!</strong><br>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus impedit totam, dignissimos at itaque molestias quaerat!
            </p>
        </div>
    </div>
</body>

</html>
