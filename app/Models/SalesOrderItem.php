<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_order_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    /**
     * Item belongs to Sales Order
     */
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    /**
     * Item belongs to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
