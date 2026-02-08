<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\PurchaseReturnController;
use App\Http\Controllers\Admin\SalesInvoiceController;
use App\Http\Controllers\Admin\SalesOrderController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\SalesReturnController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');
Route::get('/', function () {
    return view('login');
})->name('welcome');
Route::middleware('admin')->group(function () {
    // Category Routes
    Route::get('admin/catagory/index', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('admin/catagory/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('admin/catagory/store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('admin/catagory/edit/{category}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('admin/catagory/update/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('admin/catagory/destroy/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    // Product Routes
    Route::get('admin/product/index', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('admin/product/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('admin/product/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('admin/product/edit/{product}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('admin/product/update/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('admin/product/destroy/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    // Unit Routes
    Route::get('admin/unit/index', [UnitController::class, 'index'])->name('admin.units.index');
    Route::get('admin/unit/create', [UnitController::class, 'create'])->name('admin.units.create');
    Route::post('admin/unit/store', [UnitController::class, 'store'])->name('admin.units.store');
    Route::get('admin/unit/edit/{unit}', [UnitController::class, 'edit'])->name('admin.units.edit');
    Route::put('admin/unit/update/{unit}', [UnitController::class, 'update'])->name('admin.units.update');
    Route::delete('admin/unit/destroy/{unit}', [UnitController::class, 'destroy'])->name('admin.units.destroy');
    // Vendor Routes
    Route::get('admin/vendor/index', [VendorController::class, 'index'])->name('admin.vendors.index');
    Route::get('admin/vendor/create', [VendorController::class, 'create'])->name('admin.vendors.create');
    Route::post('admin/vendor/store', [VendorController::class, 'store'])->name('admin.vendors.store');
    Route::get('admin/vendor/edit/{vendor}', [VendorController::class, 'edit'])->name('admin.vendors.edit');
    Route::put('admin/vendor/update/{vendor}', [VendorController::class, 'update'])->name('admin.vendors.update');
    Route::delete('admin/vendor/destroy/{vendor}', [VendorController::class, 'destroy'])->name('admin.vendors.destroy');
    // Stock History Route
    Route::get('products/{product}/stock-history',
        [ProductController::class, 'stockHistory']
    )->name('admin.products.stock.history');
    // Purchase  Routes
    Route::get('admin/purchases', [PurchaseController::class, 'index'])->name('admin.purchases.index');
    Route::get('admin/purchases/create', [PurchaseController::class, 'create'])->name('admin.purchases.create');
    Route::post('admin/purchases', [PurchaseController::class, 'store'])->name('admin.purchases.store');
    // Purchase Return Routes
    Route::get('admin/purchase-returns', [PurchaseReturnController::class, 'index'])->name('admin.purchase-returns.index');
    Route::get('admin/purchase-returns/create', [PurchaseReturnController::class, 'create'])->name('admin.purchase-returns.create');
    Route::post('admin/purchase-returns', [PurchaseReturnController::class, 'store'])->name('admin.purchase-returns.store');
    Route::get('admin/purchase-returns/{return}', [PurchaseReturnController::class, 'show'])->name('admin.purchase-returns.show');
    Route::get(
        'admin/purchase-returns/{purchaseReturn}/pdf',
        [PurchaseReturnController::class, 'pdf']
    )->name('admin.purchase-returns.pdf');

    // Purchase Order Routes
    Route::get('admin/purchase-orders', [PurchaseOrderController::class, 'index'])
        ->name('admin.purchase-orders.index');

    Route::get('admin/purchase-orders/create', [PurchaseOrderController::class, 'create'])
        ->name('admin.purchase-orders.create');

    Route::post('admin/purchase-orders', [PurchaseOrderController::class, 'store'])
        ->name('admin.purchase-orders.store');

    Route::post(
        'admin/purchase-orders/{purchaseOrder}/approve',
        [PurchaseOrderController::class, 'approve']
    )->name('admin.purchase-orders.approve');

    Route::post(
        'admin/purchase-orders/{purchaseOrder}/convert',
        [PurchaseOrderController::class, 'convertToPurchase']
    )->name('admin.purchase-orders.convert');

    // Stock Routes (Commented Out)
    // Cusotmer Routes
    Route::get('admin/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('admin/customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
    Route::post('admin/customers', [CustomerController::class, 'store'])->name('admin.customers.store');
    Route::get('admin/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit');
    Route::put('admin/customers/{customer}/update', [CustomerController::class, 'update'])->name('admin.customers.update');

    // Sales Order Routes
    Route::get('admin/sales-orders', [SalesOrderController::class, 'index'])
        ->name('admin.sales-orders.index');

    Route::get('admin/sales-orders/create', [SalesOrderController::class, 'create'])
        ->name('admin.sales-orders.create');
    Route::post('admin/sales-orders', [SalesOrderController::class, 'store'])
        ->name('admin.sales-orders.store');
    Route::get('admin/sales-orders/{salesOrder}',
        [SalesOrderController::class, 'show']
    )->name('admin.sales-orders.show');

    Route::get('admin/sales-orders/{salesOrder}/edit',
        [SalesOrderController::class, 'edit']
    )->name('admin.sales-orders.edit');

    Route::put('admin/sales-orders/{salesOrder}',
        [SalesOrderController::class, 'update']
    )->name('admin.sales-orders.update');

    // Sales Invoice Routes
    Route::post(
        'admin/sales-orders/{salesOrder}/convert-invoice',
        [SalesInvoiceController::class, 'storeFromOrder']
    )->name('admin.sales-orders.convert-invoice');
    // Sales Invoice Routes
    Route::get('admin/sales-invoices',
        [SalesInvoiceController::class, 'index']
    )->name('admin.sales-invoices.index');

    Route::get('admin/sales-invoices/{invoice}',
        [SalesInvoiceController::class, 'show']
    )->name('admin.sales-invoices.show');

    Route::get(
    'admin/sales-invoices/{invoice}/pdf',
    [SalesInvoiceController::class, 'pdf']
)->name('admin.sales-invoices.pdf');


//seles return routes will be added here later
Route::get('admin/sales-returns', [SalesReturnController::class, 'index'])
    ->name('admin.sales-returns.index');

Route::get(
    'admin/sales-invoices/{invoice}/return',
    [SalesReturnController::class, 'create']
)->name('admin.sales-returns.create');

Route::post('admin/sales-returns', [SalesReturnController::class, 'store'])
    ->name('admin.sales-returns.store');

Route::get(
    'admin/sales-returns/{salesReturn}',
    [SalesReturnController::class, 'show']
)->name('admin.sales-returns.show');

    // Route::get('admin/stock/index', [StockController::class, 'index'])->name('admin.stocks.index');
    // Route::get('admin/stock/create', [StockController::class, 'create'])->name('admin.stocks.create');
    // Route::post('admin/stock/store', [StockController::class, 'store'])->name('admin.stocks.store');
    // Route::get('admin/stock/edit/{stock}', [StockController::class, 'edit'])->name('admin.stocks.edit');
    // Route::post('admin/stock/update/{stock}', [StockController::class, 'update'])->name('admin.stocks.update');
    // Route::delete('admin/stock/destroy/{stock}', [StockController::class, 'destroy'])->name('admin.stocks.destroy');

});
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('loggedin', [LoginController::class, 'loggedIn'])->name('loggedin');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');