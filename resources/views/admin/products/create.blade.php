@extends('layouts.admin')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.products.index') }}" class="text-green-600 hover:text-green-700 font-semibold mb-4 inline-block">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
    <h1 class="text-3xl font-bold text-gray-900">Tambah Produk Baru</h1>
</div>

<div class="bg-white rounded-xl shadow-md p-8">
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded text-red-700">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded text-green-700">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Product Name -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                   placeholder="Contoh: WhatsApp Premium Mod">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi *</label>
            <textarea name="description" rows="5" required
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                      placeholder="Jelaskan tentang aplikasi ini...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Price (Range dari varian) -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Produk *</label>
            <input type="number" name="price" value="{{ old('price', 0) }}" required min="0" step="1000"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-100"
                   placeholder="Akan otomatis terisi range harga dari varian" readonly>
            <p class="text-sm text-gray-500 mt-1">Range harga akan otomatis dihitung dari varian yang Anda tambahkan</p>
            @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Features -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Fitur-Fitur Premium</label>
            <textarea name="features" rows="4"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                      placeholder="Pisahkan setiap fitur dengan enter (baris baru)&#10;Contoh:&#10;- Anti banned&#10;- Tema custom&#10;- Download status">{{ old('features') }}</textarea>
            <p class="text-sm text-gray-500 mt-1">Pisahkan setiap fitur dengan baris baru</p>
            @error('features')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Paket Tersedia (Varian Produk) -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Paket Tersedia *</label>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-3">
                <p class="text-sm text-gray-700 mb-3">Tambahkan varian paket dengan nama dan harga masing-masing:</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <input type="text" id="variant_name_input" placeholder="Nama varian (contoh: 1 Hari)" 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <input type="number" id="variant_price_input" placeholder="Harga (contoh: 15000)" min="0" step="1000"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <input type="number" id="variant_stock_input" placeholder="Stok (contoh: 100)" min="0" value="999"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                </div>
                <button type="button" onclick="addVariant()" class="mt-3 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-semibold">
                    <i class="fas fa-plus mr-2"></i>Tambah Varian
                </button>
            </div>

            <!-- List Varian yang Sudah Ditambahkan -->
            <div id="variants_list" class="space-y-2">
                <p class="text-sm text-gray-500 italic">Belum ada varian. Tambahkan varian pertama di atas.</p>
            </div>
            
            <!-- Hidden inputs untuk submit -->
            <input type="hidden" name="packages" id="packages_json">
        </div>

        <!-- Image Upload -->
        <div class="mb-8">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
            <div class="flex items-center gap-4">
                <label class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <i class="fas fa-cloud-upload-alt text-5xl text-gray-400 mb-3"></i>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                        <p class="text-xs text-gray-500">PNG, JPG, WEBP (Max. 2MB)</p>
                    </div>
                    <input type="file" name="image" class="hidden" accept="image/*" id="imageInput">
                </label>
            </div>
            <div id="imagePreview" class="mt-4 hidden">
                <img src="" alt="Preview" class="w-48 h-48 object-cover rounded-lg">
            </div>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                <i class="fas fa-save mr-2"></i>Simpan Produk
            </button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 text-white px-8 py-3 rounded-lg hover:bg-gray-600 transition-colors font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
// Image preview
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});

// Variants management
let variants = [];

function addVariant() {
    const name = document.getElementById('variant_name_input').value.trim();
    const price = parseFloat(document.getElementById('variant_price_input').value);
    const stock = parseInt(document.getElementById('variant_stock_input').value);

    if (!name || !price || price <= 0) {
        alert('Mohon isi nama varian dan harga dengan benar!');
        return;
    }

    if (!stock || stock < 0) {
        alert('Mohon isi stok dengan benar!');
        return;
    }

    // Add to array
    variants.push({
        name: name,
        price: price,
        stock: stock
    });

    // Clear inputs
    document.getElementById('variant_name_input').value = '';
    document.getElementById('variant_price_input').value = '';
    document.getElementById('variant_stock_input').value = '999';

    // Update display
    updateVariantsList();
    updatePriceRange();
}

function removeVariant(index) {
    variants.splice(index, 1);
    updateVariantsList();
    updatePriceRange();
}

function updateVariantsList() {
    const container = document.getElementById('variants_list');
    
    if (variants.length === 0) {
        container.innerHTML = '<p class="text-sm text-gray-500 italic">Belum ada varian. Tambahkan varian pertama di atas.</p>';
        return;
    }

    let html = '';
    variants.forEach((variant, index) => {
        html += `
            <div class="flex items-center justify-between bg-white border border-gray-300 rounded-lg p-4">
                <div class="flex-1">
                    <h4 class="font-bold text-gray-900">${variant.name}</h4>
                    <p class="text-sm text-gray-600">Harga: Rp ${variant.price.toLocaleString('id-ID')} | Stok: ${variant.stock}</p>
                </div>
                <button type="button" onclick="removeVariant(${index})" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm font-semibold">
                    <i class="fas fa-trash mr-1"></i>Hapus
                </button>
            </div>
        `;
    });

    container.innerHTML = html;

    // Update hidden field with JSON
    document.getElementById('packages_json').value = JSON.stringify(variants);
}

function updatePriceRange() {
    const priceInput = document.querySelector('input[name="price"]');
    
    if (variants.length === 0) {
        priceInput.value = 0;
        priceInput.placeholder = 'Akan otomatis terisi range harga dari varian';
        return;
    }

    const prices = variants.map(v => v.price);
    const minPrice = Math.min(...prices);
    const maxPrice = Math.max(...prices);

    if (minPrice === maxPrice) {
        priceInput.value = minPrice;
        priceInput.placeholder = 'Rp ' + minPrice.toLocaleString('id-ID');
    } else {
        priceInput.value = minPrice; // Simpan harga terendah sebagai base price
        priceInput.placeholder = 'Rp ' + minPrice.toLocaleString('id-ID') + ' - Rp ' + maxPrice.toLocaleString('id-ID');
    }
}

// Validate before submit
document.querySelector('form').addEventListener('submit', function(e) {
    if (variants.length === 0) {
        e.preventDefault();
        alert('Mohon tambahkan minimal 1 varian produk!');
        return false;
    }
});
</script>

@endsection
