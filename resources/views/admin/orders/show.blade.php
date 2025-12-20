@extends('layouts.admin')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors mb-4">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Order
    </a>
    
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Order #{{ $order->order_number }}</h1>
    <p class="text-gray-600">Informasi lengkap pesanan</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Main Order Info -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-shopping-bag text-green-600 mr-2"></i>
                Produk yang Dipesan
            </h2>
            
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-start gap-4 pb-4 border-b border-gray-200 last:border-0">
                        <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://via.placeholder.com/80x80/10b981/ffffff?text=APK' }}" 
                             alt="{{ $item->product->name }}"
                             class="w-20 h-20 object-cover rounded-lg">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">{{ $item->product->name }}</h3>
                            @if($item->variant_name)
                                <p class="text-sm text-green-600 font-semibold mt-1">
                                    <i class="fas fa-box mr-1"></i>Varian: {{ $item->variant_name }}
                                </p>
                            @endif
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($item->product->description, 80) }}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-sm text-gray-600">Qty: <strong>{{ $item->quantity }}</strong></span>
                                <span class="text-sm text-gray-600">Harga: <strong>Rp {{ number_format($item->price, 0, ',', '.') }}</strong></span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Total -->
            <div class="mt-6 pt-4 border-t-2 border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-900">Total Pembayaran:</span>
                    <span class="text-2xl font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Proof -->
        @if($order->payment_proof)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center justify-between">
                    <span>
                        <i class="fas fa-receipt text-blue-600 mr-2"></i>
                        Bukti Pembayaran
                    </span>
                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="text-sm bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                        <i class="fas fa-external-link-alt mr-1"></i>Buka Tab Baru
                    </a>
                </h2>
                <div class="relative">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                         alt="Bukti Pembayaran"
                         id="payment-proof-img"
                         class="w-full rounded-lg border border-gray-200 max-h-96 object-contain bg-gray-50"
                         onload="this.style.display='block';"
                         onerror="this.style.display='none'; document.getElementById('error-message').style.display='block';">
                    <div id="error-message" style="display:none;" class="text-center py-8 text-red-500">
                        <i class="fas fa-exclamation-triangle text-4xl mb-2"></i>
                        <p class="font-semibold">Gagal memuat gambar</p>
                        <p class="text-sm mt-2">Path: {{ $order->payment_proof }}</p>
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="inline-block mt-3 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Coba Buka di Tab Baru
                        </a>
                    </div>
                </div>
                <div class="mt-3 text-sm text-gray-500 bg-gray-50 p-3 rounded">
                    <p><strong>Path:</strong> <code class="bg-white px-2 py-1 rounded">{{ $order->payment_proof }}</code></p>
                    <p class="mt-1"><strong>URL:</strong> <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ asset('storage/' . $order->payment_proof) }}</a></p>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-6">
        
        <!-- Customer Info -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user text-purple-600 mr-2"></i>
                Informasi Customer
            </h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Nama</p>
                    <p class="font-semibold text-gray-900">{{ $order->customer->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-semibold text-gray-900">{{ $order->customer->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="font-semibold text-gray-900">{{ $order->customer->address ?? 'Tidak ada' }}</p>
                </div>
            </div>
        </div>

        <!-- Order Status -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                Status Order
            </h2>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Status Verifikasi Pembayaran</p>
                    @if($order->payment_status === 'verified')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                        </span>
                    @elseif($order->payment_status === 'awaiting_verification')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>Menunggu Verifikasi
                        </span>
                        <a href="{{ route('admin.payments.index') }}" class="block mt-2 text-sm text-blue-600 hover:underline">
                            <i class="fas fa-arrow-right mr-1"></i>Verifikasi Sekarang
                        </a>
                    @elseif($order->payment_status === 'rejected')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i>Ditolak
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                            <i class="fas fa-clock mr-1"></i>Belum Upload Bukti
                        </span>
                    @endif
                </div>

                <div>
                    <p class="text-sm text-gray-600 mb-1">Status Aktivasi Premium</p>
                    @if($order->status === 'paid')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>Sudah Diaktivasi
                        </span>
                    @elseif($order->status === 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>Belum Diaktivasi
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i>Gagal
                        </span>
                    @endif
                </div>
                
                <div>
                    <p class="text-sm text-gray-600">Tanggal Order</p>
                    <p class="font-semibold text-gray-900">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>

            <!-- Update Status Form -->
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mt-6">
                @csrf
                @method('PUT')
                
                <label class="block text-sm font-semibold text-gray-700 mb-1">Update Status Aktivasi Premium</label>
                <p class="text-xs text-gray-500 mb-2">Status ini untuk menandai bahwa premium app sudah diaktivasi (di luar website)</p>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 mb-3">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Belum Diaktivasi</option>
                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Sudah Diaktivasi (Lunas)</option>
                    <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Gagal</option>
                </select>
                
                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                    <i class="fas fa-save mr-2"></i>Update Status
                </button>
            </form>
        </div>

    </div>
</div>

@endsection
