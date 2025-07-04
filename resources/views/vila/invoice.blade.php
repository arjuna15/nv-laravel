<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Penting untuk responsif -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 40px;
            background: #fefefe url('/images/invoice-bg.png') no-repeat top left;
            background-size: cover;
            color: #002F6C;
        }

        .header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            margin: 0;
            font-size: 22px;
        }

        .invoice-title small {
            font-size: 14px;
            display: block;
        }

        .info {
            margin-bottom: 20px;
        }

        .info strong {
            display: block;
            font-size: 16px;
        }

        .info small {
            font-size: 14px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table thead {
            background: #002F6C;
            color: white;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            font-size: 14px;
        }

        .total {
            font-weight: bold;
            font-size: 20px;
            margin-top: 20px;
            text-align: right;
            border-top: 2px solid #002F6C;
            padding-top: 10px;
        }

        .footer {
            margin-top: 40px;
            font-size: 13px;
        }

        .footer .admin {
            font-weight: bold;
        }

        .footer .address {
            margin-top: 8px;
        }

        .footer .contacts {
            margin-top: 4px;
        }

        /* Responsif */
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .invoice-title {
                text-align: left;
                margin-top: 10px;
            }

            table th, table td {
                font-size: 12px;
                padding: 8px;
            }

            .total {
                font-size: 18px;
            }

            .logo {
                font-size: 24px;
            }

            .invoice-title h2 {
                font-size: 20px;
            }

            .invoice-title small {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">nge <span style="color:#002F6C">VILLA.YUK</span></div>
        <div class="invoice-title">
            <h2>INVOICE</h2>
            <small>Tanggal<br>4 Juli 2025</small>
        </div>
    </div>

    <div class="info">
        <strong>Kepada</strong>
        <small>Fahsa Aula Nasaul Husna</small>
        <small>Jl. Mawar No. 21, Bogor</small>
    </div>

    <table>
        <thead>
            <tr>
                <th>Cekin</th>
                <th>Cekout</th>
                <th>Full Price</th>
                <th>Payment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>6 Juli 2025<br>PUKUL 14:00</td>
                <td>8 Juli 2025<br>PUKUL 12:00</td>
                <td>Rp 2.500.000</td>
                <td>Rp 1.000.000</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        TOTAL &nbsp;&nbsp;&nbsp;&nbsp; Rp 2.500.000
    </div>

    <div class="footer">
        <div class="admin">Admin Ngevillayuk</div>
        <div class="address">
            Office : Jln. Cikopo Selatan, Sukagalih<br>
            Megamendung, Bogor
        </div>
        <div class="contacts">
            Admin 1 : 0896-0770-9270<br>
            Admin 2 : 0895-3606-10100
        </div>
    </div>
</body>
</html>
