<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get customer data
        $customer = $user->customer;
        
        if (!$customer) {
            return redirect('/product')->with('info', 'Selamat datang! Silakan checkout produk untuk membuat profil Anda.');
        }
        
        // Stats
        $totalOrders = $customer->orders()->count();
        $totalSpent = $customer->orders()->where('status', 'paid')->sum('total');
        $pendingOrders = $customer->orders()->where('status', 'pending')->count();
        
        // Recent orders
        $recentOrders = $customer->orders()
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('buyer.dashboard', compact('customer', 'totalOrders', 'totalSpent', 'pendingOrders', 'recentOrders'));
    }
    
    public function orders()
    {
        $user = Auth::user();
        $customer = $user->customer;
        
        if (!$customer) {
            return redirect('/product')->with('error', 'Anda belum memiliki profil customer.');
        }
        
        $orders = $customer->orders()
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('buyer.orders', compact('orders'));
    }
}
