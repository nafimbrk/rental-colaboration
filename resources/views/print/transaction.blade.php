<!DOCTYPE html>
<html>
<head>
    <title>Cetak Transaksi</title>
    <style>
        body { font-family: Arial; font-size: 14px }
        h2 { margin-bottom: 10px }
        table { width: 100%; border-collapse: collapse }
        td { padding: 6px }
    </style>
</head>
<body onload="window.print()">

<h2>Detail Transaksi Rental Mobil</h2>

<table border="1">
    <tr>
        <td>Customer</td>
        <td>{{ $transaction->customer->name }}</td>
    </tr>
    <tr>
        <td>Mobil</td>
        <td>{{ $transaction->car->model }}</td>
    </tr>
    <tr>
        <td>Plat Nomor</td>
        <td>{{ $transaction->car->plate_number }}</td>
    </tr>
    <tr>
        <td>Tanggal Sewa</td>
        <td>{{ $transaction->start_date }} - {{ $transaction->end_date }}</td>
    </tr>
    <tr>
        <td>Total</td>
        <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Status Pembayaran</td>
        <td>{{ strtoupper($transaction->payment->status) }}</td>
    </tr>
</table>

</body>
</html>
