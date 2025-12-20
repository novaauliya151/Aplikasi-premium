<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentVerifyController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'items.product'])
            ->whereNotNull('payment_proof')
            ->where('payment_status', 'awaiting_verification')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.payments.index', compact('orders'));
    }

    public function verify(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'action' => 'required|in:verify,reject',
            'notes' => 'nullable|string',
        ]);

        if ($request->action === 'verify') {
            $order->payment_status = 'verified';
            $order->verified_at = now();
            $statusText = 'diverifikasi dan disetujui';
        } else {
            $order->payment_status = 'rejected';
            $statusText = 'ditolak';
        }
        
        $order->notes = $request->notes;
        $order->save();
        
        return redirect()->back()->with('success', "Pembayaran order #{$order->order_number} berhasil {$statusText}!");
    }

    public function sendAccess($id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_status !== 'verified') {
            return redirect()->back()->with('error', 'Pembayaran belum diverifikasi!');
        }

        // TODO: Implement email/WhatsApp notification
        // Send download link or activation code to customer
        
        $order->access_sent_at = now();
        $order->save();

        return redirect()->back()->with('success', "Link akses berhasil dikirim ke customer!");
    }
}
