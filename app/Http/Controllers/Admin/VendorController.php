<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->get();
        return view('admin.vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.vendor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'gst_no'=> 'nullable|string|max:50',
            'status'=> 'required|boolean',
        ]);

        Vendor::create($request->only([
            'name','email','phone','gst_no','address','status'
        ]));

        return redirect()
            ->route('admin.vendors.index')
            ->with('success', 'Vendor created successfully');
    }

    public function edit(Vendor $vendor)
    {
        return view('admin.vendor.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'gst_no'=> 'nullable|string|max:50',
            'status'=> 'required|boolean',
        ]);

        $vendor->update($request->only([
            'name','email','phone','gst_no','address','status'
        ]));

        return redirect()
            ->route('admin.vendors.index')
            ->with('success', 'Vendor updated successfully');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()
            ->route('admin.vendors.index')
            ->with('success', 'Vendor deleted successfully');
    }
}