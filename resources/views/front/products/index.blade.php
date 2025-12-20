@extends('layouts.app')

@section('content')

<!-- Header Section -->
<div class="mb-8 text-center">
    <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
        Daftar Produk Premium
    </h1>
    <p class="text-gray-600 text-lg max-w-2xl mx-auto">
        Temukan aplikasi premium terbaik dengan harga terjangkau dan kualitas terjamin
    </p>
</div>

<!-- Products Grid -->
@if($products->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @foreach($products as $p)
            <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover group">
                <!-- Product Image -->
                <div class="relative overflow-hidden h-48">
                    <img src="{{ $p->image_url ? $p->image_url : 'https://via.placeholder.com/400x300/10b981/ffffff?text=APK+Premium' }}" 
                         alt="{{ $p->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-3 right-3">
                        <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                            <i class="fas fa-star mr-1"></i>Premium
                        </span>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-1 group-hover:text-green-600 transition-colors">
                        {{ $p->name }}
                    </h3>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2 leading-relaxed">
                        {{ Str::limit($p->description, 80) }}
                    </p>

                    <!-- Price -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Harga</p>
                            <p class="text-2xl font-bold text-green-600">
                                Rp {{ number_format($p->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('product.show', $p->slug) }}"
                       class="block text-center bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-lg font-semibold hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 shadow-md">
                        <i class="fas fa-eye mr-2"></i>Lihat Detail
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $products->links() }}
    </div>
@else
    <div class="text-center py-16">
        <div class="inline-block bg-gray-100 rounded-full p-6 mb-4">
            <i class="fas fa-box-open text-6xl text-gray-400"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Produk</h3>
        <p class="text-gray-500">Produk akan segera tersedia. Silakan cek kembali nanti.</p>
    </div>
@endif

@endsection
