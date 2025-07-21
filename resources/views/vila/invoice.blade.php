<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <style>
    @page {
      size: A4;
      margin: 0;
    }

    body {
      width: 794px;
      height: 1123px;
      margin: 0 auto;
      padding: 0;
      font-family: 'Arial', sans-serif;
      background-color: #fdfdfc;
      color: #002f6c;
      box-sizing: border-box;
    }

    .container {
      width: 700px;
      margin: 0 auto;
      padding: 40px 30px 100px 30px;
      position: relative;
    }

    .header-logo {
      font-size: 56px;
      font-weight: bold;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 80px;
    }

    .invoice-title {
      position: absolute;
      top: 40px;
      right: 30px;
      text-align: right;
    }

    .invoice-title h2 {
      font-size: 32px;
      margin: 150px 0 30px 0;
    }

    .invoice-title p {
      font-size: 18px;
      margin: 4px 0;
    }

    .kepada {
      margin-top: 20px;
      margin-bottom: 40px;
    }

    .kepada h4 {
      font-size: 20px;
      font-weight: bold;
      margin: 4px 0;
    }

    .table-wrapper {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .table {
      border-collapse: collapse;
      width: 100%;
      max-width: 100%;
    }

    .table thead {
      background-color: #002f6c;
      color: white;
    }

    .table th {
      text-align: center;
      padding: 10px;
      font-size: 20px;
    }

    .table td {
      text-align: center;
      padding: 12px 10px;
      font-size: 16px;
      color: #002f6c;
    }

    .table tbody td {
      background-color: #f2f2f2;
    }

    .total {
      margin-top: 40px;
      text-align: right;
      font-weight: bold;
      font-size: 24px;
      border-top: 2px solid #002f6c;
      padding-top: 8px;
    }

    .footer-section {
      width: 100%;
      display: flex;
      justify-content: space-between;
      margin-top: 200px;
      font-size: 14px;
    }

    .footer-section .footer-left,
    .footer-section .footer-right {
      width: 48%;
    }

    .footer-left {
      color: #333;
      line-height: 1.6;
    }

    .footer-right {
      text-align: right;
      font-weight: bold;
    }

  </style>
</head>
<body>
  <div class="container">
    <div class="header-logo">NGEVILLAYUK</div>

    <div class="invoice-title">
      <h2>INVOICE</h2>
      <p>Tanggal</p>
      <p>{{ \Carbon\Carbon::parse($reservasi->created_at)->format('d F Y') }}</p>
    </div>

    <div class="kepada">
      <h4 style="margin-bottom:20px">Kepada</h4>
      <h4>{{ strtoupper($reservasi->nama_tamu) }}</h4>
      <h4>{{ strtoupper($reservasi->status) }} {{ strtoupper($villa->nama_vila) }}</h4>
    </div>

    <div class="table-wrapper">
      <table class="table">
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
            <td>
              {{ \Carbon\Carbon::parse($reservasi->check_in_date)->format('d M Y') }}<br>
              PUKUL 14:00
            </td>
            <td>
              {{ \Carbon\Carbon::parse($reservasi->check_out_date)->format('d M Y') }}<br>
              PUKUL 12:00
            </td>
            <td>{{ number_format($reservasi->total, 0, ',', '.') }}</td>
            <td>{{ number_format($reservasi->payment_amount ?? 0, 0, ',', '.') }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="total">
      TOTAL &nbsp;&nbsp; {{ number_format($reservasi->total, 0, ',', '.') }}
    </div>

    <div class="footer-section">
      <div class="footer-left">
        Office: Jln.Cikopo Selatan, Sukagalih<br>
        Megamendung, Bogor<br>
        Admin 1: 0896-0770-9270<br>
        Admin 2: 0895-3606-10100
      </div>
      <div class="footer-right">
        Admin Ngevillayuk
      </div>
    </div>
  </div>
</body>
</html>
