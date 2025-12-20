@extends('layouts.admin')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.products.index') }}" class="text-green-600 hover:text-green-700 font-semibold mb-4 inline-block">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
    <h1 class="text-3xl font-bold text-gray-900">Edit Produk: {{ $product->name }}</h1>
</div>

@if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded">
        <p class="text-red-700 font-semibold mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Terdapat kesalahan:</p>
        <ul class="list-disc list-inside text-red-600 text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded text-red-700">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded text-green-700">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

<!-- FORM UPDATE PRODUK -->
<div class="bg-white rounded-xl shadow-md p-8 mb-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">
        <i class="fas fa-edit text-blue-600 mr-2"></i>Informasi Produk
    </h2>
    
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Dasar (Rp) *</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="1000"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi *</label>
            <textarea name="description" rows="4" required
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Fitur (opsional)</label>
            <textarea name="features" rows="3"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                      placeholder="Contoh:&#10;✓ Akun premium original&#10;✓ Garansi 100%&#10;✓ Support 24/7">{{ old('features', $product->features) }}</textarea>
            <p class="text-sm text-gray-500 mt-1">Pisahkan setiap fitur dengan baris baru.</p>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
            
            @if($product->image_url)
                <div class="mb-4">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-48 h-48 object-cover rounded-lg border">
                </div>
            @endif
            
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
            <p class="text-sm text-gray-500 mt-1">PNG, JPG, WEBP (Max. 2MB). Kosongkan jika tidak ingin mengubah gambar.</p>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                <i class="fas fa-save mr-2"></i>Update Produk
            </button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 text-white px-8 py-3 rounded-lg hover:bg-gray-600 font-semibold inline-block">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<!-- KELOLA VARIAN -->
<div class="bg-white rounded-xl shadow-md p-8 mb-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">
        <i class="fas fa-boxes text-purple-600 mr-2"></i>Kelola Varian Produk
    </h2>

    <!-- List Varian yang Sudah Ada -->
    @if(isset($product->variants) && $product->variants->count() > 0)
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Varian yang Sudah Ada ({{ $product->variants->count() }}):</h3>
            <div class="space-y-3">
                @foreach($product->variants as $variant)
                    <div class="border border-gray-300 rounded-lg p-4 {{ $variant->is_active ? 'bg-green-50 border-green-300' : 'bg-gray-50' }}">
                        <form action="{{ route('admin.variants.update', $variant->id) }}" method="POST" class="variant-update-form">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                <div class="md:col-span-3">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Varian</label>
                                    <input type="text" name="name" value="{{ old('name', $variant->name) }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Harga (Rp)</label>
                                    <input type="number" name="price" value="{{ old('price', $variant->price) }}" required min="0" step="1000"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Stok</label>
                                    <input type="number" name="stock" value="{{ old('stock', $variant->stock) }}" required min="0"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="flex items-center mb-2">
                                        <input type="checkbox" name="is_active" value="1" {{ $variant->is_active ? 'checked' : '' }}
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700 font-semibold">{{ $variant->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </label>
                                </div>
                                
                                <div class="md:col-span-3 flex gap-2">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-semibold whitespace-nowrap">
                                        <i class="fas fa-save mr-1"></i>Update
                                    </button>
                                    <button type="button" onclick="confirmDeleteVariant({{ $variant->id }})" 
                                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm font-semibold whitespace-nowrap">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="mb-8 p-6 bg-yellow-50 border border-yellow-200 rounded-lg text-center">
            <i class="fas fa-info-circle text-yellow-600 text-2xl mb-2"></i>
            <p class="text-yellow-700 font-semibold">Belum ada varian untuk produk ini.</p>
            <p class="text-yellow-600 text-sm mt-1">Silakan tambahkan varian pertama di bawah (contoh: "7 Hari", "30 Hari", dll).</p>
        </div>
    @endif

    <!-- Form Tambah Varian Baru -->
    <div class="bg-green-50 border-2 border-green-300 rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">
            <i class="fas fa-plus-circle text-green-600 mr-2"></i>Tambah Varian Baru
        </h3>
        
        <form action="{{ route('admin.products.variants.store', $product->id) }}" method="POST" class="variant-add-form">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Varian *</label>
                    <input type="text" name="name" required placeholder="Contoh: 7 Hari" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp) *</label>
                    <input type="number" name="price" required min="0" step="1000" placeholder="30000"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stok *</label>
                    <input type="number" name="stock" required min="0" value="999" placeholder="999"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                
                <div class="flex flex-col">
                    <label class="flex items-center mb-2">
                        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-green-600 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                    </label>
                    <button type="submit" class="w-full bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-semibold">
                        <i class="fas fa-plus mr-2"></i>Tambah Varian
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- KELOLA PROMO -->
<div class="bg-white rounded-xl shadow-md p-8 mb-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">
        <i class="fas fa-tags text-orange-600 mr-2"></i>Kelola Promo
    </h2>

    <!-- List Promo yang Sudah Ada -->
    @php
        $allPromos = isset($product->variants) ? $product->variants->flatMap(function($variant) {
            return $variant->promos ?? collect();
        }) : collect();
    @endphp
    
    @if($allPromos->count() > 0)
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Promo Aktif ({{ $allPromos->count() }}):</h3>
            <div class="space-y-3">
                @foreach($allPromos as $promo)
                    @php
                        $isValid = $promo->is_active && 
                                   now()->between($promo->start_date, $promo->end_date);
                    @endphp
                    <div class="border border-gray-300 rounded-lg p-4 {{ $isValid ? 'bg-green-50 border-green-300' : 'bg-gray-50' }}">
                        <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST" class="promo-update-form">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Varian</label>
                                    <p class="text-sm font-bold text-gray-900">{{ $promo->variant->name }}</p>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Promo</label>
                                    <input type="text" name="name" value="{{ $promo->name }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tipe & Nilai</label>
                                    <div class="flex gap-1">
                                        <select name="type" required class="w-1/2 px-2 py-2 border border-gray-300 rounded-lg text-sm">
                                            <option value="nominal" {{ $promo->type == 'nominal' ? 'selected' : '' }}>Rp</option>
                                            <option value="percent" {{ $promo->type == 'percent' ? 'selected' : '' }}>%</option>
                                        </select>
                                        <input type="number" name="value" value="{{ $promo->value }}" required min="0" step="0.01"
                                               class="w-1/2 px-2 py-2 border border-gray-300 rounded-lg text-sm">
                                    </div>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Mulai</label>
                                    <input type="date" name="start_date" value="{{ $promo->start_date->format('Y-m-d') }}" required
                                           class="w-full px-2 py-2 border border-gray-300 rounded-lg text-sm">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Berakhir</label>
                                    <input type="date" name="end_date" value="{{ $promo->end_date->format('Y-m-d') }}" required
                                           class="w-full px-2 py-2 border border-gray-300 rounded-lg text-sm">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="flex items-center mb-2">
                                        <input type="checkbox" name="is_active" value="1" {{ $promo->is_active ? 'checked' : '' }}
                                               class="w-4 h-4 text-orange-600 border-gray-300 rounded">
                                        <span class="ml-2 text-xs text-gray-700 font-semibold">{{ $promo->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </label>
                                    @if($isValid)
                                        <span class="inline-block bg-green-100 text-green-700 text-xs px-2 py-1 rounded mb-2">
                                            <i class="fas fa-check-circle"></i> Berjalan
                                        </span>
                                    @else
                                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded mb-2">
                                            <i class="fas fa-clock"></i> Tidak Aktif
                                        </span>
                                    @endif
                                    <div class="flex gap-2">
                                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-blue-700 whitespace-nowrap">
                                            <i class="fas fa-save"></i> Update
                                        </button>
                                        <button type="button" onclick="confirmDeletePromo({{ $promo->id }})" 
                                                class="bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-red-700 whitespace-nowrap">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Form Tambah Promo Baru -->
    @if($product->variants->count() > 0)
        <div class="bg-orange-50 border-2 border-orange-300 rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">
                <i class="fas fa-plus-circle text-orange-600 mr-2"></i>Tambah Promo Baru
            </h3>
            
            <form action="{{ route('admin.variants.promos.store', $product->variants->first()->id) }}" method="POST" class="promo-add-form" id="addPromoForm">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Varian *</label>
                        <select id="variantSelectForPromo" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            @foreach($product->variants as $variant)
                                <option value="{{ $variant->id }}">{{ $variant->name }} - Rp {{ number_format($variant->price, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Promo *</label>
                        <input type="text" name="name" required placeholder="Contoh: Diskon Akhir Tahun"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Diskon *</label>
                        <select name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="nominal">Nominal (Rp)</option>
                            <option value="percent">Persen (%)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai Diskon *</label>
                        <input type="number" name="value" required min="0" step="0.01" placeholder="10000 atau 20"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai *</label>
                        <input type="date" name="start_date" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Berakhir *</label>
                        <input type="date" name="end_date" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-orange-600 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Aktif setelah dibuat</span>
                    </label>
                    
                    <button type="submit" class="bg-orange-600 text-white px-8 py-2 rounded-lg hover:bg-orange-700 font-semibold">
                        <i class="fas fa-plus mr-2"></i>Tambah Promo
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="p-6 bg-yellow-50 border border-yellow-200 rounded-lg text-center">
            <p class="text-yellow-700"><i class="fas fa-info-circle mr-2"></i>Tambahkan varian terlebih dahulu sebelum membuat promo.</p>
        </div>
    @endif
</div>

<!-- Hidden Forms untuk Delete -->
<form id="deleteVariantForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="deletePromoForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
// Update form action saat varian dipilih untuk promo
document.getElementById('variantSelectForPromo')?.addEventListener('change', function() {
    const variantId = this.value;
    const form = document.getElementById('addPromoForm');
    form.action = '/admin/variants/' + variantId + '/promos';
});

// Set initial form action
window.addEventListener('DOMContentLoaded', function() {
    const variantSelect = document.getElementById('variantSelectForPromo');
    if (variantSelect) {
        const variantId = variantSelect.value;
        const form = document.getElementById('addPromoForm');
        form.action = '/admin/variants/' + variantId + '/promos';
    }
});

// Confirm delete variant
function confirmDeleteVariant(variantId) {
    if (confirm('Yakin ingin menghapus varian ini?\n\nSemua promo terkait juga akan terhapus secara otomatis.')) {
        const form = document.getElementById('deleteVariantForm');
        form.action = '/admin/variants/' + variantId;
        form.submit();
    }
}

// Confirm delete promo
function confirmDeletePromo(promoId) {
    if (confirm('Yakin ingin menghapus promo ini?')) {
        const form = document.getElementById('deletePromoForm');
        form.action = '/admin/promos/' + promoId;
        form.submit();
    }
}

// Handle checkbox value pada form submit
document.addEventListener('DOMContentLoaded', function() {
    // Untuk semua form varian dan promo, pastikan checkbox value benar
    const allForms = document.querySelectorAll('.variant-update-form, .variant-add-form, .promo-update-form, .promo-add-form');
    
    allForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const checkbox = form.querySelector('input[name="is_active"]');
            if (checkbox && !checkbox.checked) {
                // Tambahkan hidden input dengan value 0 jika checkbox tidak dicentang
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'is_active';
                hiddenInput.value = '0';
                form.appendChild(hiddenInput);
            }
        });
    });
});
</script>

@endsection
