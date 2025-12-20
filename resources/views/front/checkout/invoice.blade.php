<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->order_number }} - APK Premium</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .header p {
            opacity: 0.9;
            font-size: 14px;
        }
        .invoice-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 30px 40px;
            border-bottom: 2px solid #e5e7eb;
        }
        .info-block h3 {
            color: #10b981;
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .info-block p {
            margin: 5px 0;
            font-size: 14px;
        }
        .invoice-details {
            padding: 30px 40px;
        }
        .invoice-number {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 15px 20px;
            margin-bottom: 30px;
        }
        .invoice-number strong {
            color: #10b981;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        thead {
            background: #f9fafb;
        }
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        tbody tr:hover {
            background: #f9fafb;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            margin-top: 30px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }
        .total-row.final {
            border-top: 2px solid #10b981;
            padding-top: 15px;
            margin-top: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #10b981;
        }
        .footer {
            background: #f9fafb;
            padding: 30px 40px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: #fef3c7;
            color: #92400e;
        }
        .status-badge.paid {
            background: #d1fae5;
            color: #065f46;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .invoice-container {
                box-shadow: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <h1>🚀 APK PREMIUM</h1>
            <p>Platform Aplikasi Premium Terpercaya</p>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div class="info-block">
                <h3>Kepada:</h3>
                <p><strong>{{ $order->customer->name }}</strong></p>
                <p>{{ $order->customer->email }}</p>
                <p>{{ $order->customer->address ?? '-' }}</p>
            </div>
            <div class="info-block">
                <h3>Detail Invoice:</h3>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d F Y') }}</p>
                <p><strong>Waktu:</strong> {{ $order->created_at->format('H:i') }} WIB</p>
                <p><strong>Status:</strong> 
                    @if($order->status == 'paid')
                        <span class="status-badge paid">✓ Lunas</span>
                    @else
                        <span class="status-badge">⏳ Pending</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="invoice-number">
                <strong>INVOICE #{{ $order->order_number }}</strong>
            </div>

            <!-- Items Table -->
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product->name }}</strong>
                            @if($item->product->description)
                                <br><small style="color: #6b7280;">{{ Str::limit($item->product->description, 60) }}</small>
                            @endif
                        </td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right"><strong>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Total Section -->
            <div class="total-section">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span>Biaya Admin:</span>
                    <span>Rp 0</span>
                </div>
                <div class="total-row final">
                    <span>TOTAL PEMBAYARAN:</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Terima kasih atas kepercayaan Anda!</strong></p>
            <p>Untuk pertanyaan, hubungi kami di <strong>info@apkpremium.com</strong> atau <strong>+62 812-3456-7890</strong></p>
            <p style="margin-top: 15px; font-size: 12px;">
                &copy; {{ date('Y') }} APK Premium. All Rights Reserved.<br>
                Dokumen ini dibuat secara otomatis dan sah tanpa tanda tangan.
            </p>
        </div>
    </div>

    <!-- Print Button -->
    <div style="text-align: center; margin-top: 20px;" class="no-print">
        <button onclick="window.print()" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 12px 30px; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            🖨️ Cetak / Download PDF
        </button>
    </div>
</body>
</html>
