<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Tampilkan form checkout untuk product (route model binding)
    public function showCheckoutForm(Request $request, Product $product)
    {
        // Get variant if provided
        $selectedVariant = null;
        if ($request->has('variant_id')) {
            $selectedVariant = ProductVariant::where('product_id', $product->id)
                ->where('id', $request->variant_id)
                ->where('is_active', true)
                ->first();
        }
        
        // If no variant selected but product has variants, use first active variant
        if (!$selectedVariant && $product->activeVariants->count() > 0) {
            $selectedVariant = $product->activeVariants->first();
        }
        
        return view('front.checkout.checkout', compact('product', 'selectedVariant'));
    }

    // Proses checkout
    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'nama'       => 'required',
            'email'      => 'required|email',
            'phone'      => 'required',
            'alamat'     => 'required',
            'qty'        => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Get price from variant if exists, otherwise use product price
        $price = $product->price;
        $variantInfo = null;
        
        if ($request->variant_id) {
            $variant = ProductVariant::where('id', $request->variant_id)
                ->where('product_id', $product->id)
                ->where('is_active', true)
                ->firstOrFail();
            
            // Check stock
            if ($variant->stock < $request->qty) {
                return back()->with('error', 'Stok varian tidak mencukupi!')->withInput();
            }
            
            // Use final price (after promo if exists)
            $price = $variant->final_price;
            $variantInfo = $variant->name;
            
            // Reduce stock
            $variant->decrement('stock', $request->qty);
        }
        
        $total = $price * $request->qty;

        // Cari atau buat customer
        $customer = Customer::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->nama,
                'phone' => $request->phone,
                'address' => $request->alamat,
                'user_id' => Auth::check() ? Auth::id() : null,
            ]
        );

        // Update customer jika ada perubahan data
        $customer->update([
            'name' => $request->nama,
            'phone' => $request->phone,
            'address' => $request->alamat,
        ]);

        // Buat order (set subtotal + shipping so DB required fields are filled)
        $order = Order::create([
            'customer_id' => $customer->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'subtotal' => $total,
            'shipping' => 0,
            'total' => $total,
            'status' => 'pending',
        ]);

        // Buat order items
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'variant_id' => $request->variant_id ?? null,
            'variant_name' => $variantInfo,
            'quantity' => $request->qty,
            'price' => $price,
        ]);

        return redirect()
            ->route('payment.upload.form', ['order_id' => $order->id])
            ->with('success', 'Pesanan berhasil dibuat. Silakan upload bukti pembayaran.');
    }
}
