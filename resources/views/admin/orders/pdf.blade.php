<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #10b981;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #10b981;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
            background: #f9fafb;
            padding: 15px;
            border-radius: 5px;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-item {
            display: table-cell;
            padding: 5px 10px;
            width: 25%;
        }
        .info-label {
            font-weight: bold;
            color: #374151;
            font-size: 11px;
            text-transform: uppercase;
        }
        .info-value {
            font-size: 16px;
            color: #10b981;
            font-weight: bold;
        }
        .filter-section {
            margin-bottom: 20px;
            padding: 10px;
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
        }
        .filter-section p {
            margin: 3px 0;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead {
            background-color: #10b981;
            color: white;
        }
        th {
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        tr:hover {
            background-color: #f9fafb;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-failed {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .payment-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .payment-verified {
            background-color: #d1fae5;
            color: #065f46;
        }
        .payment-awaiting {
            background-color: #fef3c7;
            color: #92400e;
        }
        .payment-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .payment-pending {
            background-color: #e5e7eb;
            color: #374151;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .font-bold {
            font-weight: bold;
        }
        .text-green {
            color: #10b981;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>APK PREMIUM</h1>
        <p>Laporan Pesanan</p>
        <p>Tanggal Cetak: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <!-- Filter Info -->
    @if($filters['search'] || $filters['status'] || $filters['date_from'] || $filters['date_to'])
    <div class="filter-section">
        <strong>Filter Diterapkan:</strong>
        @if($filters['search'])
            <p>• Pencarian: <strong>{{ $filters['search'] }}</strong></p>
        @endif
        @if($filters['status'])
            <p>• Status: <strong>{{ ucfirst($filters['status']) }}</strong></p>
        @endif
        @if($filters['date_from'])
            <p>• Dari Tanggal: <strong>{{ date('d F Y', strtotime($filters['date_from'])) }}</strong></p>
        @endif
        @if($filters['date_to'])
            <p>• Sampai Tanggal: <strong>{{ date('d F Y', strtotime($filters['date_to'])) }}</strong></p>
        @endif
    </div>
    @endif

    <!-- Summary -->
    <div class="info-section">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Total Pesanan</div>
                <div class="info-value">{{ $totalOrders }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Lunas</div>
                <div class="info-value">{{ $paidOrders }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Pending</div>
                <div class="info-value">{{ $pendingOrders }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total Pendapatan</div>
                <div class="info-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">No</th>
                <th style="width: 12%;">Order ID</th>
                <th style="width: 15%;">Customer</th>
                <th style="width: 20%;">Produk</th>
                <th style="width: 12%; text-align: right;">Total</th>
                <th style="width: 10%;">Verifikasi</th>
                <th style="width: 10%;">Aktivasi</th>
                <th style="width: 13%;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold">#{{ $order->order_number }}</td>
                    <td>
                        <div class="font-bold">{{ $order->customer->name ?? 'N/A' }}</div>
                        <div style="font-size: 9px; color: #6b7280;">{{ $order->customer->email ?? '' }}</div>
                    </td>
                    <td>
                        @foreach($order->items as $item)
                            <div style="margin-bottom: 2px;">
                                {{ $item->product->name }}
                                @if($item->variant_name)
                                    <span style="font-size: 9px; color: #10b981;">({{ $item->variant_name }})</span>
                                @endif
                                x{{ $item->quantity }}
                            </div>
                        @endforeach
                    </td>
                    <td class="text-right font-bold text-green">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @if($order->payment_status === 'verified')
                            <span class="payment-badge payment-verified">✓ Terverifikasi</span>
                        @elseif($order->payment_status === 'awaiting_verification')
                            <span class="payment-badge payment-awaiting">⏳ Menunggu</span>
                        @elseif($order->payment_status === 'rejected')
                            <span class="payment-badge payment-rejected">✗ Ditolak</span>
                        @else
                            <span class="payment-badge payment-pending">- Pending</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($order->status === 'paid')
                            <span class="status-badge status-paid">✓ Aktif</span>
                        @elseif($order->status === 'pending')
                            <span class="status-badge status-pending">⏳ Belum</span>
                        @else
                            <span class="status-badge status-failed">✗ Gagal</span>
                        @endif
                    </td>
                    <td style="font-size: 10px;">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 30px; color: #6b7280;">
                        Tidak ada data pesanan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem APK Premium</p>
        <p>© {{ date('Y') }} APK Premium. All rights reserved.</p>
    </div>
</body>
</html>
