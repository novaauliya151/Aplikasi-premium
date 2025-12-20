<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Promo;
use Illuminate\Http\Request;

class AdminPromoController extends Controller
{
    // Store new promo
    public function store(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:nominal,percent',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean'
        ]);

        // variant_id sudah dari route parameter
        $validated['variant_id'] = $variant->id;
        $validated['is_active'] = $request->has('is_active');

        Promo::create($validated);

        return redirect()->route('admin.products.edit', $variant->product_id)
            ->with('success', 'Promo berhasil ditambahkan!');
    }

    // Update promo
    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:nominal,percent',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $promo->update($validated);

        return redirect()->route('admin.products.edit', $promo->variant->product_id)
            ->with('success', 'Promo berhasil diupdate!');
    }

    // Delete promo
    public function destroy(Promo $promo)
    {
        $productId = $promo->variant->product_id;
        $promo->delete();

        return redirect()->route('admin.products.edit', $productId)
            ->with('success', 'Promo berhasil dihapus!');
    }
}
