@extends('layouts.app')

@section('content')

<!-- Breadcrumb -->
<nav class="mb-6">
    <ol class="flex items-center space-x-2 text-sm text-gray-600">
        <li><a href="/" class="hover:text-green-600 transition-colors"><i class="fas fa-home"></i> Home</a></li>
        <li><i class="fas fa-chevron-right text-xs"></i></li>
        <li><a href="/product" class="hover:text-green-600 transition-colors">Produk</a></li>
        <li><i class="fas fa-chevron-right text-xs"></i></li>
        <li class="text-gray-800 font-medium">{{ Str::limit($product->name, 30) }}</li>
    </ol>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

    <!-- Product Image -->
    <div class="space-y-4">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden p-4">
            <img src="{{ $product->image_url ? $product->image_url : 'https://via.placeholder.com/600x600/10b981/ffffff?text=APK+Premium' }}"
                 alt="{{ $product->name }}"
                 class="w-full h-auto object-cover rounded-xl">
        </div>
    </div>

    <!-- Product Details -->
    <div class="space-y-6">
        <!-- Title -->
        <div>
            <div class="inline-block bg-green-100 text-green-700 text-sm font-semibold px-4 py-1 rounded-full mb-3">
                <i class="fas fa-check-circle mr-1"></i>Produk Premium
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                {{ $product->name }}
            </h1>
        </div>

        <!-- Description -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
            <h2 class="font-bold text-lg text-gray-800 mb-3 flex items-center">
                <i class="fas fa-info-circle mr-2 text-green-600"></i>Deskripsi Produk
            </h2>
            <p class="text-gray-700 leading-relaxed">
                {{ $product->description }}
            </p>
        </div>

        <!-- Features -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                <i class="fas fa-star mr-2 text-yellow-500"></i>Fitur Unggulan
            </h3>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <i class="fas fa-check text-green-600 mt-1 mr-3"></i>
                    <span class="text-gray-700">Aplikasi original dan berlisensi</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-green-600 mt-1 mr-3"></i>
                    <span class="text-gray-700">Update gratis selamanya</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-green-600 mt-1 mr-3"></i>
                    <span class="text-gray-700">Support 24/7 dari tim kami</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-green-600 mt-1 mr-3"></i>
                    <span class="text-gray-700">Garansi uang kembali 30 hari</span>
                </li>
            </ul>
        </div>

        <!-- Variants & Price -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border-2 border-green-200">
            @if($product->activeVariants->count() > 0)
                <!-- Variant Selection -->
                <div class="mb-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-box mr-2 text-green-600"></i>Pilih Paket
                    </h3>
                    <div class="space-y-3">
                        @foreach($product->activeVariants as $variant)
                            @php
                                $hasPromo = $variant->active_promo != null;
                                $finalPrice = $variant->final_price;
                                $originalPrice = $variant->price;
                            @endphp
                            <label class="block cursor-pointer">
                                <input type="radio" name="variant" value="{{ $variant->id }}" 
                                       data-price="{{ $finalPrice }}"
                                       data-original="{{ $originalPrice }}"
                                       data-has-promo="{{ $hasPromo ? 'true' : 'false' }}"
                                       data-promo-name="{{ $hasPromo ? $variant->active_promo->name : '' }}"
                                       class="sr-only variant-radio"
                                       {{ $loop->first ? 'checked' : '' }}>
                                <div class="variant-option border-2 border-gray-300 rounded-lg p-4 hover:border-green-500 transition-all {{ $loop->first ? 'border-green-500 bg-white' : 'bg-gray-50' }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-900 text-lg">{{ $variant->name }}</h4>
                                            @if($hasPromo)
                                                <p class="text-xs text-orange-600 font-semibold mt-1">
                                                    <i class="fas fa-tag mr-1"></i>{{ $variant->active_promo->name }}
                                                </p>
                                            @endif
                                            @if($variant->stock > 0)
                                                <p class="text-xs text-gray-500 mt-1">Stok: {{ $variant->stock }}</p>
                                            @else
                                                <p class="text-xs text-red-500 mt-1">Stok habis</p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            @if($hasPromo)
                                                <p class="text-sm text-gray-400 line-through">Rp {{ number_format($originalPrice, 0, ',', '.') }}</p>
                                                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($finalPrice, 0, ',', '.') }}</p>
                                                <p class="text-xs text-red-600 font-semibold">Hemat Rp {{ number_format($variant->discount_amount, 0, ',', '.') }}</p>
                                            @else
                                                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($finalPrice, 0, ',', '.') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Selected Price Display -->
                <div class="flex items-center justify-between mb-6 bg-white rounded-lg p-4 border border-green-200">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Harga</p>
                        <p class="text-3xl font-bold text-green-600" id="selected-price">
                            Rp {{ number_format($product->activeVariants->first()->final_price, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1" id="promo-info"></p>
                    </div>
                    <div class="text-right">
                        <div class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full inline-block">
                            <i class="fas fa-fire mr-1"></i>HOT DEAL
                        </div>
                    </div>
                </div>

                <!-- Checkout Button -->
                <button onclick="checkoutWithVariant()" class="w-full inline-flex bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-xl text-lg font-bold hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 shadow-lg items-center justify-center space-x-2">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Checkout Sekarang</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            @else
                <!-- No Variants - Show Original Price -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Harga Spesial</p>
                        <p class="text-4xl font-bold text-green-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full inline-block">
                            <i class="fas fa-fire mr-1"></i>HOT DEAL
                        </div>
                    </div>
                </div>

                <!-- Checkout Button -->
                <a href="{{ route('checkout.view', $product) }}" class="w-full inline-flex bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-xl text-lg font-bold hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 shadow-lg items-center justify-center space-x-2">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Checkout Sekarang</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            @endif

            <!-- Security Badge -->
            <div class="mt-4 flex items-center justify-center text-sm text-gray-600">
                <i class="fas fa-lock mr-2 text-green-600"></i>
                <span>Pembayaran aman & terpercaya</span>
            </div>
        </div>

        <!-- Back Button -->
        <a href="/product" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            <span>Kembali ke Daftar Produk</span>
        </a>
    </div>

</div>

<script>
// Handle variant selection
document.querySelectorAll('.variant-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        // Update visual styling
        document.querySelectorAll('.variant-option').forEach(opt => {
            opt.classList.remove('border-green-500', 'bg-white');
            opt.classList.add('border-gray-300', 'bg-gray-50');
        });
        
        this.parentElement.querySelector('.variant-option').classList.remove('border-gray-300', 'bg-gray-50');
        this.parentElement.querySelector('.variant-option').classList.add('border-green-500', 'bg-white');
        
        // Update price display
        const price = parseFloat(this.dataset.price);
        const originalPrice = parseFloat(this.dataset.original);
        const hasPromo = this.dataset.hasPromo === 'true';
        const promoName = this.dataset.promoName;
        
        document.getElementById('selected-price').textContent = 
            'Rp ' + price.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        
        const promoInfo = document.getElementById('promo-info');
        if (hasPromo) {
            const discount = originalPrice - price;
            promoInfo.innerHTML = `<i class="fas fa-tag mr-1 text-orange-600"></i><span class="text-orange-600 font-semibold">${promoName}</span> - Hemat Rp ${discount.toLocaleString('id-ID')}`;
        } else {
            promoInfo.innerHTML = '';
        }
    });
});

// Checkout with selected variant
function checkoutWithVariant() {
    const selectedVariant = document.querySelector('.variant-radio:checked');
    if (selectedVariant) {
        window.location.href = '{{ route("checkout.view", $product) }}?variant_id=' + selectedVariant.value;
    }
}

// Initialize first variant info
window.addEventListener('DOMContentLoaded', function() {
    const firstRadio = document.querySelector('.variant-radio:checked');
    if (firstRadio) {
        const hasPromo = firstRadio.dataset.hasPromo === 'true';
        const promoName = firstRadio.dataset.promoName;
        const originalPrice = parseFloat(firstRadio.dataset.original);
        const price = parseFloat(firstRadio.dataset.price);
        
        const promoInfo = document.getElementById('promo-info');
        if (hasPromo) {
            const discount = originalPrice - price;
            promoInfo.innerHTML = `<i class="fas fa-tag mr-1 text-orange-600"></i><span class="text-orange-600 font-semibold">${promoName}</span> - Hemat Rp ${discount.toLocaleString('id-ID')}`;
        }
    }
});
</script>

@endsection
