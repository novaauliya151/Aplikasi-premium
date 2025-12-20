@extends('layouts.admin')

@section('content')

<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Admin</h1>
    <p class="text-gray-600">Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Berikut ringkasan sistem Anda.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <!-- Total Orders -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalOrders) }}</h3>
            </div>
            <div class="bg-blue-100 rounded-full p-4">
                <i class="fas fa-shopping-cart text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Revenue</p>
                <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-green-100 rounded-full p-4">
                <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Pending Payments</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($pendingPayments) }}</h3>
            </div>
            <div class="bg-yellow-100 rounded-full p-4">
                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Products</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalProducts) }}</h3>
            </div>
            <div class="bg-purple-100 rounded-full p-4">
                <i class="fas fa-box text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-pink-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Customers</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalCustomers) }}</h3>
            </div>
            <div class="bg-pink-100 rounded-full p-4">
                <i class="fas fa-users text-pink-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts & Recent Orders -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Monthly Sales Chart -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-chart-line text-green-600 mr-2"></i>
            Penjualan Bulanan (6 Bulan Terakhir)
        </h2>
        <canvas id="salesChart" height="100"></canvas>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-star text-yellow-500 mr-2"></i>
            Produk Terlaris
        </h2>
        <div class="space-y-4">
            @forelse($topProducts as $product)
                <div class="flex items-center justify-between pb-3 border-b border-gray-200 last:border-0">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">{{ Str::limit($product->name, 20) }}</p>
                        <p class="text-xs text-gray-600">Terjual: {{ $product->total_sold }} unit</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-green-600">Rp {{ number_format($product->revenue, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm text-center py-8">Belum ada data penjualan</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900 flex items-center">
            <i class="fas fa-receipt text-blue-600 mr-2"></i>
            Order Terbaru
        </h2>
        <a href="/admin/orders" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <span class="font-mono text-sm font-semibold text-blue-600">#{{ $order->order_number }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $order->customer->name }}</p>
                                <p class="text-xs text-gray-500">{{ $order->customer->email }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-sm text-gray-900">
                                {{ $order->items->first()->product->name ?? 'N/A' }}
                                @if($order->items->count() > 1)
                                    <span class="text-xs text-gray-500">(+{{ $order->items->count() - 1 }} lainnya)</span>
                                @endif
                            </p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if($order->status === 'paid')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Lunas
                                </span>
                            @elseif($order->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>Gagal
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2 text-gray-400"></i>
                            <p>Belum ada order</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart');
    
    // Prepare data
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const salesData = @json($monthlySales);
    
    const labels = salesData.map(item => monthNames[item.month - 1] + ' ' + item.year);
    const revenues = salesData.map(item => item.total);
    const counts = salesData.map(item => item.count);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (Rp)',
                data: revenues,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y',
            }, {
                label: 'Jumlah Order',
                data: counts,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y1',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                if (context.datasetIndex === 0) {
                                    label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                } else {
                                    label += context.parsed.y + ' order';
                                }
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>

@endsection
