<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Stock;
use App\Models\StockLog;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'category',
            'unit',
            'stock',
            'latestPrice',
        ])->latest()->get();

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        // $units = Unit::where('status', 1)->get();
        $units = Unit::all();

        return view('admin.product.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'alert_qty' => 'nullable|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        DB::transaction(function () use ($request) {

            // Create Product
            $product = Product::create([
                'category_id' => $request->category_id,
                'unit_id' => $request->unit_id,
                'name' => $request->name,
                'sku' => $request->sku,
                'price' => $request->cost_price, // IMPORTANT
                'alert_qty' => $request->alert_qty ?? 0,
                'status' => $request->status,
            ]);

            // Create Initial Price
            ProductPrice::create([
                'product_id' => $product->id,
                'cost_price' => $request->cost_price,
                'selling_price' => $request->selling_price,
            ]);

            // Create Stock
            Stock::create([
                'product_id' => $product->id,
                'quantity' => 0,
            ]);
        });

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $product->load('latestPrice');

        $categories = Category::where('status', 1)->get();
        // $units = Unit::where('status', 1)->get();
        $units = Unit::all();

        return view('admin.product.edit', compact('product', 'categories', 'units'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'alert_qty' => 'nullable|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        DB::transaction(function () use ($request, $product) {

            // update product
            $product->update([
                'category_id' => $request->category_id,
                'unit_id' => $request->unit_id,
                'name' => $request->name,
                'price' => $request->cost_price,
                'alert_qty' => $request->alert_qty ?? 0,
                'status' => $request->status,
            ]);

            // add new price record (history maintained)
            ProductPrice::create([
                'product_id' => $product->id,
                'cost_price' => $request->cost_price,
                'selling_price' => $request->selling_price,
            ]);
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function stockHistory(Product $product)
    {
        $logs = StockLog::where('product_id', $product->id)
            ->latest()
            ->get();

        return view('admin.product.stock-history', compact('product', 'logs'));
    }
}
