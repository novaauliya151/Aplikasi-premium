<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class AdminProductVariantController extends Controller
{
    // Store new variant
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['product_id'] = $product->id;
        $validated['is_active'] = $request->has('is_active');

        ProductVariant::create($validated);

        return redirect()->route('admin.products.edit', $product->id)
            ->with('success', 'Varian berhasil ditambahkan!');
    }

    // Update variant
    public function update(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $variant->update($validated);

        return redirect()->route('admin.products.edit', $variant->product_id)
            ->with('success', 'Varian berhasil diupdate!');
    }

    // Delete variant
    public function destroy(ProductVariant $variant)
    {
        $productId = $variant->product_id;
        $variant->delete();

        return redirect()->route('admin.products.edit', $productId)
            ->with('success', 'Varian berhasil dihapus!');
    }
}
