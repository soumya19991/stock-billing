<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * List customers
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('admin.customer.index', compact('customers'));
    }

    /**
     * Create form
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store customer
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);

        Customer::create($request->all());

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer created successfully');
    }

    /**
     * Edit form
     */
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    /**
     * Update customer
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);

        $customer->update($request->all());

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer updated successfully');
    }
}