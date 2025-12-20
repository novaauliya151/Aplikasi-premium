@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Riwayat Pesanan</h1>
        <p class="text-gray-600">Semua pesanan yang pernah Anda buat</p>
    </div>

    <!-- Orders List -->
    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-4">
                    <div>
                        <h3 class="font-mono text-lg font-bold text-blue-600 mb-1">#{{ $order->order_number }}</h3>
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        @if($order->payment_status === 'verified')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>Pembayaran Terverifikasi
                            </span>
                        @elseif($order->payment_status === 'awaiting_verification')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-2"></i>Menunggu Verifikasi Admin
                            </span>
                        @elseif($order->payment_status === 'rejected')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-2"></i>Pembayaran Ditolak
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                                <i class="fas fa-hourglass-half mr-2"></i>Belum Upload Bukti Bayar
                            </span>
                        @endif
                        
                        @if($order->status === 'paid')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                <i class="fas fa-star mr-1"></i>Premium Aktif
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="border-t border-gray-200 pt-4 space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4">
                            <img src="{{ $item->product->image_url ? $item->product->image_url : 'https://via.placeholder.com/80x80/10b981/ffffff?text=APK' }}" 
                                 alt="{{ $item->product->name }}"
                                 class="w-20 h-20 object-cover rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">{{ $item->product->name }}</h4>
                                @if($item->variant_name)
                                    <p class="text-sm text-green-600 font-semibold mt-1"><i class="fas fa-box mr-1"></i>Varian: {{ $item->variant_name }}</p>
                                @endif                                @if($item->variant_name)
                                    <p class="text-sm text-green-600 font-semibold mt-1"><i class="fas fa-box mr-1"></i>Varian: {{ $item->variant_name }}</p>
                                @endif                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($item->product->description, 80) }}</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total & Actions -->
                <div class="border-t border-gray-200 mt-4 pt-4 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-600">Total Pembayaran</p>
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="flex gap-3">
                        @if(!$order->payment_proof)
                            <a href="{{ route('payment.upload.form', $order->id) }}" 
                               class="inline-flex items-center bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                                <i class="fas fa-upload mr-2"></i>Upload Bukti Bayar
                            </a>
                        @elseif($order->payment_proof && $order->payment_status === 'awaiting_verification')
                            <span class="inline-flex items-center bg-yellow-100 text-yellow-800 px-6 py-3 rounded-lg font-semibold">
                                <i class="fas fa-hourglass-half mr-2"></i>Bukti Sedang Diverifikasi
                            </span>
                        @endif
                        
                        @if($order->payment_status === 'verified')
                            <button onclick="openReceipt{{ $order->id }}()" 
                               class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                                <i class="fas fa-receipt mr-2"></i>Lihat Struk
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal Struk untuk order ini -->
            @if($order->payment_status === 'verified')
            <div id="receiptModal{{ $order->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    <!-- Header Modal -->
                    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-6 rounded-t-xl">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold mb-2">Struk Pembayaran</h2>
                                <p class="text-green-100">Pesanan #{{ $order->order_number }}</p>
                            </div>
                            <button onclick="closeReceipt{{ $order->id }}()" class="text-white hover:text-gray-200 transition-colors">
                                <i class="fas fa-times text-2xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Content Struk -->
                    <div class="p-6">
                        <!-- Info Pembeli -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-user text-green-600 mr-2"></i>Informasi Pembeli
                            </h3>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-gray-600">Nama</p>
                                    <p class="font-semibold text-gray-900">{{ $order->customer->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">No. HP</p>
                                    <p class="font-semibold text-gray-900">{{ $order->customer->phone }}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-gray-600">Email</p>
                                    <p class="font-semibold text-gray-900">{{ $order->customer->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Info Pesanan -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-shopping-bag text-green-600 mr-2"></i>Detail Pesanan
                            </h3>
                            <div class="space-y-3">
                                @foreach($order->items as $item)
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                        @if($item->variant_name)
                                            <p class="text-sm text-green-600"><i class="fas fa-box mr-1"></i>{{ $item->variant_name }}</p>
                                        @endif
                                        <p class="text-sm text-gray-600">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-bold text-gray-900">Total Pembayaran</p>
                                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Info Pembayaran -->
                        <div class="mb-6">
                            <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-credit-card text-green-600 mr-2"></i>Status Pembayaran
                            </h3>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-gray-700">Status:</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Tanggal Pesanan:</span>
                                    <span class="font-semibold text-gray-900">{{ $order->created_at->format('d F Y, H:i') }} WIB</span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer / Actions -->
                        <div class="flex gap-3 pt-4">
                            <button onclick="printReceipt{{ $order->id }}()" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                                <i class="fas fa-print mr-2"></i>Print Struk
                            </button>
                            <button onclick="closeReceipt{{ $order->id }}()" class="flex-1 bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                                <i class="fas fa-times mr-2"></i>Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openReceipt{{ $order->id }}() {
                    document.getElementById('receiptModal{{ $order->id }}').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }

                function closeReceipt{{ $order->id }}() {
                    document.getElementById('receiptModal{{ $order->id }}').classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }

                function printReceipt{{ $order->id }}() {
                    window.print();
                }

                // Close modal when clicking outside
                document.getElementById('receiptModal{{ $order->id }}').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeReceipt{{ $order->id }}();
                    }
                });
            </script>
            @endif

        @empty
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class="fas fa-shopping-bag text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-600 mb-6">Yuk mulai belanja aplikasi premium favoritmu!</p>
                <a href="/product" class="inline-block bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                    <i class="fas fa-shopping-cart mr-2"></i>Mulai Belanja
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection
