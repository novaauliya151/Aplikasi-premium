<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'items.product']);

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed',
            'notes' => 'nullable|string',
        ]);

        $order->status = $request->status;
        $order->notes = $request->notes;
        
        if ($request->status === 'paid') {
            $order->verified_at = now();
        }
        
        $order->save();

        return redirect()->back()->with('success', 'Status order berhasil diupdate!');
    }

    public function exportPdf(Request $request)
    {
        $query = Order::with(['customer', 'items.product']);

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        // Calculate totals
        $totalRevenue = $orders->sum('total');
        $totalOrders = $orders->count();
        $paidOrders = $orders->where('status', 'paid')->count();
        $pendingOrders = $orders->where('status', 'pending')->count();

        $filters = [
            'search' => $request->search,
            'status' => $request->status,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];

        $pdf = Pdf::loadView('admin.orders.pdf', compact('orders', 'totalRevenue', 'totalOrders', 'paidOrders', 'pendingOrders', 'filters'))
            ->setPaper('a4', 'landscape');

        $filename = 'Laporan-Pesanan-' . date('Y-m-d-His') . '.pdf';
        
        return $pdf->download($filename);
    }
}
