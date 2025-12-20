<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'features' => 'nullable|string',
            'packages' => 'required|string', // JSON string dari variants
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);

        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                // Ensure directory exists
                Storage::disk('public')->makeDirectory('products');
                $path = $request->file('image')->store('products', 'public');

                // Verify file saved successfully
                if (!Storage::disk('public')->exists($path)) {
                    Log::error('Failed to store product image', ['path' => $path, 'product' => $validated['name']]);
                    return back()->withInput()->with('error', 'Gagal menyimpan gambar. Coba lagi.');
                }

                Log::info('Stored product image', ['path' => $path, 'product' => $validated['name']]);
                $validated['image'] = $path;
            } catch (\Exception $e) {
                Log::error('Exception while storing product image', ['error' => $e->getMessage()]);
                return back()->withInput()->with('error', 'Terjadi kesalahan saat mengupload gambar.');
            }
        }

        // Create product
        $product = Product::create($validated);

        // Create variants from JSON
        if ($request->packages) {
            $variants = json_decode($request->packages, true);
            if (is_array($variants)) {
                foreach ($variants as $variant) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'name' => $variant['name'],
                        'price' => $variant['price'],
                        'stock' => $variant['stock'] ?? 999,
                        'is_active' => true
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk dan varian berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        // Load relasi variants dan promos untuk ditampilkan di edit form
        $product->load(['variants.promos']);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'features' => 'nullable|string',
            'packages' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Update slug if name changed
        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Check if slug already exists (excluding current product)
            $slugCount = Product::where('slug', $validated['slug'])
                ->where('id', '!=', $product->id)
                ->count();
            
            if ($slugCount > 0) {
                $validated['slug'] = $validated['slug'] . '-' . time();
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                // Delete old image
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                Storage::disk('public')->makeDirectory('products');
                $path = $request->file('image')->store('products', 'public');

                if (!Storage::disk('public')->exists($path)) {
                    Log::error('Failed to store new product image', ['path' => $path, 'product_id' => $product->id]);
                    return back()->withInput()->with('error', 'Gagal menyimpan gambar baru. Coba lagi.');
                }

                Log::info('Stored new product image', ['path' => $path, 'product_id' => $product->id]);
                $validated['image'] = $path;
            } catch (\Exception $e) {
                Log::error('Exception while storing new product image', ['error' => $e->getMessage(), 'product_id' => $product->id]);
                return back()->withInput()->with('error', 'Terjadi kesalahan saat mengupload gambar baru.');
            }
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        // Delete image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
