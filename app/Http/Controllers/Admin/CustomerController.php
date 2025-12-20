<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('orders')
            ->with('orders')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders.items.product']);
        
        // Calculate stats
        $totalOrders = $customer->orders->count();
        $totalSpent = $customer->orders->where('status', 'paid')->sum('total');
        $pendingOrders = $customer->orders->where('status', 'pending')->count();
        
        return view('admin.customers.show', compact('customer', 'totalOrders', 'totalSpent', 'pendingOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
