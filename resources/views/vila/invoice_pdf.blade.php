<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
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
      font-family: 'Montserrat', sans-serif !important;
      background-color: #ffffffff;
      background-image: url('https://www.toptal.com/designers/subtlepatterns/uploads/paisley.png');
      background-repeat: repeat;
      background-size: auto;
      color: #002f6c;
      box-sizing: border-box;
    }

    .container {
      width: 700px;
      margin: 0 auto;
      padding: 40px 30px 100px 30px;
      position: relative;
      background-color: transparent;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .header-logo {
      font-size: 42px;
      font-weight: 700;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 3px;
      color: #002f6c;
      border-bottom: 3px solid #002f6c;
      padding-bottom: 20px;
      margin-bottom: 60px;
    }

    .invoice-title {
      position: absolute;
      top: 40px;
      right: 30px;
      text-align: right;
    }

    .invoice-title h2 {
      font-size: 36px;
      margin: 200px 0 20px 0;
      letter-spacing: 1px;
      color: #002f6c;
    }

    .invoice-title p {
      font-size: 16px;
      margin: 3px 0;
      color: #666;
    }

    .kepada {
      margin-top: 100px;
      margin-bottom: 40px;
    }

    .kepada h4 {
      font-size: 18px;
      margin: 5px 0;
      color: #002f6c;
    }

    .table-wrapper {
      display: flex;
      justify-content: center;
      margin-top: 80px;
    }

    .table {
      border-collapse: collapse;
      width: 100%;
      max-width: 100%;
    }

    .table thead {
      background-color: #002f6c;
      color: white;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .table th, .table td {
      text-align: center;
      padding: 12px 10px;
      font-size: 16px;
      border-bottom: 1px solid #ddd;
    }

    .table tbody td {
      background-color: #f9f9f9;
    }

    .total {
      background-color: #002f6c;
      color: white;
      padding: 12px 20px;
      font-size: 20px;
      text-align: right;
      margin-top: 50px;
      border-radius: 6px;
    }

    .footer-section {
      border-top: 2px solid #002f6c;
      width: 100%;
      display: flex;
      justify-content: space-between;
      margin-top: 250px;
      font-size: 13px;
      color: #444;
      padding-top: 12px;
    }

    .footer-left {
      line-height: 1.6;
    }

    .qr-code {
      margin-top: 40px;
      text-align: right;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header-logo">NGEVILLAYUK</div>

    <div class="invoice-title">
      <h2>INVOICE</h2>
      <p>Tanggal</p>
      <p>{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
    </div>

    <div class="kepada">
      <h4 style="margin-bottom:20px;">Kepada</h4>
      <h4>{{ strtoupper($reservasi->nama_tamu) }}</h4>
      <h4>
        {{ $reservasi->status === 'Lunas' ? 'PELUNASAN' : 'DP' }} {{ strtoupper($villa->nama_vila) }}
      </h4>
    </div>

    <div class="table-wrapper">
      <table class="table">
        <thead>
          <tr>
            <th>Check-in</th>
            <th>Check-out</th>
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
            <td>Rp {{ number_format($reservasi->total, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($reservasi->uang_masuk ?? 0, 0, ',', '.') }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="total">
      TOTAL &nbsp;&nbsp; Rp {{ number_format($reservasi->uang_masuk, 0, ',', '.') }}
    </div> 

    <div class="footer-section">
      <div class="footer-left">
        Office: Jln. Cikopo Selatan, Sukagalih<br>
        Megamendung, Bogor<br>
        Admin 1: 0896-0770-9270<br>
        Admin 2: 0895-3606-10100
      </div>
    </div>
  </div>
</body>
</html>
