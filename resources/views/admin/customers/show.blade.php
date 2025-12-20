@extends('layouts.admin')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors mb-4">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Pelanggan
    </a>
    
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Pelanggan</h1>
    <p class="text-gray-600">Informasi lengkap dan riwayat pembelian</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Customer Stats -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</h3>
            </div>
            <div class="bg-purple-100 rounded-full p-4">
                <i class="fas fa-shopping-cart text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Spending</p>
                <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-green-100 rounded-full p-4">
                <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Pending Orders</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $pendingOrders }}</h3>
            </div>
            <div class="bg-yellow-100 rounded-full p-4">
                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Order History -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-history text-blue-600 mr-2"></i>
                Riwayat Pesanan
            </h2>
            
            <div class="space-y-4">
                @forelse($customer->orders as $order)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-mono text-sm font-bold text-blue-600">#{{ $order->order_number }}</span>
                            @if($order->status === 'paid')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Lunas
                                </span>
                            @elseif($order->status === 'pending')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>Gagal
                                </span>
                            @endif
                        </div>
                        
                        <div class="space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-700">{{ $item->product->name }} <span class="text-gray-500">({{ $item->quantity }}x)</span></span>
                                    <span class="font-semibold text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-200">
                            <span class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            <span class="font-bold text-green-600">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-bag text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500">Belum ada riwayat pesanan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user text-purple-600 mr-2"></i>
                Informasi Customer
            </h2>
            
            <div class="space-y-4">
                <div class="text-center pb-4 border-b border-gray-200">
                    <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-user text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="font-bold text-xl text-gray-900">{{ $customer->name }}</h3>
                </div>
                
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-semibold text-gray-900">{{ $customer->email }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-600">Nomor Telepon</p>
                    <p class="font-semibold text-gray-900">{{ $customer->phone ?? 'Tidak ada' }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="font-semibold text-gray-900">{{ $customer->address ?? 'Tidak ada' }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-600">Bergabung Sejak</p>
                    <p class="font-semibold text-gray-900">{{ $customer->created_at->format('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
