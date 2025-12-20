@extends('layouts.admin')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Produk</h1>
        <p class="text-gray-600 mt-1">Kelola semua produk aplikasi premium</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
        <i class="fas fa-plus mr-2"></i>Tambah Produk
    </a>
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

<!-- Products Table -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Harga</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Created</th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <img src="{{ $product->image_url ? $product->image_url : 'https://via.placeholder.com/80x80/10b981/ffffff?text=APK' }}" 
                                 alt="{{ $product->name }}"
                                 class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600">{{ Str::limit($product->description, 60) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $product->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <i class="fas fa-box-open text-5xl text-gray-400 mb-3"></i>
                        <p class="text-gray-500">Belum ada produk</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($products->hasPages())
    <div class="mt-6">
        {{ $products->links() }}
    </div>
@endif

@endsection
