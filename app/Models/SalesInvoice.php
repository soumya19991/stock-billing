<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_order_id',
        'customer_id',
        'invoice_no',
        'invoice_date',
        'subtotal',
        'tax',
        'discount',
        'total',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(SalesInvoiceItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }
}