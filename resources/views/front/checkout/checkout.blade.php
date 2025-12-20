@extends('layouts.app')

@section('content')

@if (!isset($product))
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl p-8 text-center">
        <h2 class="text-xl font-bold text-red-600 mb-3">Produk tidak ditemukan</h2>
        <p class="text-gray-600 mb-4">Maaf, produk yang Anda coba beli tidak tersedia. Silakan kembali ke daftar produk.</p>
        <a href="/product" class="inline-block bg-green-500 text-white px-5 py-3 rounded-lg">Kembali ke Produk</a>
    </div>
@else

<!-- Breadcrumb -->
<nav class="mb-6">
    <ol class="flex items-center space-x-2 text-sm text-gray-600">
        <li><a href="/" class="hover:text-green-600 transition-colors"><i class="fas fa-home"></i> Home</a></li>
        <li><i class="fas fa-chevron-right text-xs"></i></li>
        <li><a href="/product" class="hover:text-green-600 transition-colors">Produk</a></li>
        <li><i class="fas fa-chevron-right text-xs"></i></li>
        <li class="text-gray-800 font-medium">Checkout</li>
    </ol>
</nav>

<div class="max-w-4xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-xl rounded-2xl p-6 lg:p-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Checkout</h1>
                        <p class="text-sm text-gray-600">Lengkapi data untuk melanjutkan pembelian</p>
                    </div>
                </div>

                {{-- FORM CHECKOUT --}}
                <form action="{{ route('checkout') }}" method="POST" class="space-y-5" id="checkoutForm">
                    @csrf

                    {{-- Hidden product ID --}}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    {{-- Hidden variant ID if selected --}}
                    @if($selectedVariant)
                        <input type="hidden" name="variant_id" value="{{ $selectedVariant->id }}" id="variant_id">
                    @endif

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user text-green-600 mr-1"></i>Nama Lengkap *
                        </label>
                        <input type="text" 
                               name="nama" 
                               required
                               placeholder="Masukkan nama lengkap Anda"
                               value="{{ old('nama') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        @error('nama')
                            <p class="text-red-600 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-green-600 mr-1"></i>Email *
                        </label>
                        <input type="email" 
                               name="email" 
                               required
                               placeholder="email@example.com"
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NOMOR TELEPON --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone text-green-600 mr-1"></i>Nomor Telepon *
                        </label>
                        <input type="tel" 
                               name="phone" 
                               required
                               placeholder="08123456789"
                               value="{{ old('phone') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ALAMAT --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt text-green-600 mr-1"></i>Alamat Lengkap *
                        </label>
                        <textarea name="alamat" 
                                  required
                                  rows="3"
                                  placeholder="Masukkan alamat lengkap Anda"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors resize-none">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-red-600 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- JUMLAH --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-boxes text-green-600 mr-1"></i>Jumlah *
                        </label>
                        <input type="number" 
                               name="qty" 
                               id="qty"
                               min="1" 
                               value="1" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        @error('qty')
                            <p class="text-red-600 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-xl text-lg font-bold hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center space-x-2">
                        <i class="fas fa-check-circle"></i>
                        <span>Konfirmasi Checkout</span>
                    </button>

                    <p class="text-xs text-gray-500 text-center mt-3">
                        <i class="fas fa-lock mr-1"></i>Transaksi Anda aman dan terenkripsi
                    </p>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow-xl rounded-2xl p-6 sticky top-24">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-receipt text-green-600 mr-2"></i>Ringkasan Pesanan
                </h2>

                <!-- Product Info -->
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <div class="flex items-start space-x-3">
                        <img src="{{ $product->image_url ? $product->image_url : 'https://via.placeholder.com/80x80/10b981/ffffff?text=APK' }}" 
                             alt="{{ $product->name }}"
                             class="w-16 h-16 object-cover rounded-lg">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 text-sm">{{ $product->name }}</h3>
                            @if($selectedVariant)
                                <p class="text-xs text-green-600 font-semibold mt-1">
                                    <i class="fas fa-box mr-1"></i>{{ $selectedVariant->name }}
                                </p>
                                @if($selectedVariant->active_promo)
                                    <p class="text-xs text-orange-600 font-semibold mt-1">
                                        <i class="fas fa-tag mr-1"></i>{{ $selectedVariant->active_promo->name }}
                                    </p>
                                @endif
                            @else
                                <p class="text-xs text-gray-500 mt-1">{{ Str::limit($product->description, 50) }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Price Details -->
                <div class="space-y-3 mb-4">
                    @php
                        $unitPrice = $selectedVariant ? $selectedVariant->final_price : $product->price;
                        $originalPrice = $selectedVariant ? $selectedVariant->price : $product->price;
                        $hasDiscount = $selectedVariant && $selectedVariant->active_promo;
                    @endphp
                    
                    @if($hasDiscount)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Harga Asli</span>
                            <span class="text-gray-400 line-through">Rp {{ number_format($originalPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Harga Promo</span>
                            <span class="font-semibold text-green-600">Rp {{ number_format($unitPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-orange-600 font-semibold">Hemat</span>
                            <span class="font-semibold text-orange-600">Rp {{ number_format($originalPrice - $unitPrice, 0, ',', '.') }}</span>
                        </div>
                    @else
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Harga Satuan</span>
                            <span class="font-semibold text-gray-800">Rp {{ number_format($unitPrice, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Jumlah</span>
                        <span class="font-semibold text-gray-800" id="qtyDisplay">1</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-bold text-green-600 text-xl" id="totalDisplay">Rp {{ number_format($unitPrice, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <h4 class="font-semibold text-sm text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-info-circle text-green-600 mr-2"></i>Informasi Pembayaran
                    </h4>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li><i class="fas fa-check text-green-600 mr-1"></i>Transfer Bank / E-Wallet</li>
                        <li><i class="fas fa-check text-green-600 mr-1"></i>Konfirmasi otomatis</li>
                        <li><i class="fas fa-check text-green-600 mr-1"></i>Produk dikirim via email</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="/product" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            <span>Kembali ke Daftar Produk</span>
        </a>
    </div>
</div>

<!-- Dynamic Total Calculator Script -->
<script>
    document.getElementById('qty')?.addEventListener('input', function() {
        const qty = parseInt(this.value) || 1;
        const price = {{ $selectedVariant ? $selectedVariant->final_price : $product->price }};
        const total = qty * price;
        
        document.getElementById('qtyDisplay').textContent = qty;
        document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
    });
</script>

@endif

@endsection
