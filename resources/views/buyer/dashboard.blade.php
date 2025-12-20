@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Saya</h1>
        <p class="text-gray-600">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Pesanan</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</h3>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <i class="fas fa-shopping-cart text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Belanja</p>
                    <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <i class="fas fa-wallet text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Pending Payment</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $pendingOrders }}</h3>
                </div>
                <div class="bg-yellow-100 rounded-full p-4">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Orders -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-history text-green-600 mr-2"></i>
                        Pesanan Terbaru
                    </h2>
                    <a href="/buyer/orders" class="text-green-600 hover:text-green-700 text-sm font-semibold">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="space-y-4">
                    @forelse($recentOrders as $order)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-mono text-sm font-bold text-blue-600">#{{ $order->order_number }}</span>
                                <div class="flex gap-2">
                                    @if($order->payment_status === 'verified')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                        </span>
                                    @elseif($order->payment_status === 'awaiting_verification')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>Menunggu Verifikasi
                                        </span>
                                    @elseif($order->payment_status === 'rejected')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            <i class="fas fa-hourglass mr-1"></i>Belum Upload
                                        </span>
                                    @endif
                                    
                                    @if($order->status === 'paid')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                            <i class="fas fa-star mr-1"></i>Premium Aktif
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $item->product->image_url ? $item->product->image_url : 'https://via.placeholder.com/60x60/10b981/ffffff?text=APK' }}" 
                                             alt="{{ $item->product->name }}"
                                             class="w-12 h-12 object-cover rounded">
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900 text-sm">{{ $item->product->name }}</p>
                                            @if($item->variant_name)
                                                <p class="text-xs text-green-600 font-semibold"><i class="fas fa-box mr-1"></i>{{ $item->variant_name }}</p>
                                            @endif
                                            <p class="text-xs text-gray-600">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-200">
                                <span class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                <span class="font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                            
                            @if(!$order->payment_proof)
                                <a href="{{ route('payment.upload.form', $order->id) }}" 
                                   class="block mt-3 text-center bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors text-sm font-semibold">
                                    <i class="fas fa-upload mr-1"></i>Upload Bukti Bayar
                                </a>
                            @elseif($order->payment_proof && $order->payment_status === 'awaiting_verification')
                                <div class="block mt-3 text-center bg-yellow-100 text-yellow-800 py-2 rounded-lg text-sm font-semibold">
                                    <i class="fas fa-hourglass-half mr-1"></i>Sedang Diverifikasi Admin
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <i class="fas fa-shopping-bag text-5xl text-gray-400 mb-3"></i>
                            <p class="text-gray-500 mb-4">Belum ada pesanan</p>
                            <a href="/product" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fas fa-shopping-cart mr-2"></i>Mulai Belanja
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Profile & Quick Actions -->
        <div class="space-y-6">
            
            <!-- Profile Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-purple-600 mr-2"></i>
                    Profil Saya
                </h2>
                
                <div class="space-y-3">
                    <div class="text-center pb-4 border-b border-gray-200">
                        <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-user text-purple-600 text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-lg text-gray-900">{{ $customer->name }}</h3>
                        <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-600">Member Since</p>
                        <p class="font-semibold text-gray-900 text-sm">{{ $customer->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-md p-6 text-white">
                <h3 class="font-bold text-lg mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="/product" class="block bg-white text-green-600 py-3 px-4 rounded-lg hover:bg-gray-100 transition-colors font-semibold text-center">
                        <i class="fas fa-shopping-bag mr-2"></i>Lihat Produk
                    </a>
                    <a href="/buyer/orders" class="block bg-white/20 backdrop-blur-sm text-white py-3 px-4 rounded-lg hover:bg-white/30 transition-colors font-semibold text-center">
                        <i class="fas fa-list mr-2"></i>Riwayat Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
