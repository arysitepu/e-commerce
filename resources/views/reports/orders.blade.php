<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Order</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Laporan Order</h3>
    <p>Periode: {{ $start }} s/d {{ $end }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Kurir</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Total Qty</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $i => $order)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                <td>{{ $order->invoice_no }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->courier->courier_name ?? '-' }}</td>
                <td>{!! $order->Alamat !!}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->total_qty }}</td>
                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>