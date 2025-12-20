<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Handle payment proof upload from buyer.
     */
    public function uploadProof(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_proof' => 'required|image|max:2048'
        ]);

        $order = Order::findOrFail($request->order_id);

        // Upload file to public disk
        $path = $request->file('payment_proof')->store('payment_proof', 'public');

        // Save to DB and update payment_status
        $order->update([
            'payment_proof' => $path,
            'payment_status' => 'awaiting_verification'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Tunggu verifikasi admin.');
    }
}
