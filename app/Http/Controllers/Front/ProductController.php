<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    // HALAMAN LIST PRODUK
    public function index()
    {
        $products = Product::latest()->paginate(12);

        return view('front.products.index', [
            'products' => $products
        ]);
    }

    // HALAMAN DETAIL PRODUK
    public function show($slug)
    {
        // CARI PRODUK BERDASARKAN SLUG
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('front.products.show', [
            'product' => $product
        ]);
    }
}
