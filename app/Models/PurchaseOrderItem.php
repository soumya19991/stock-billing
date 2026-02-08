<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'qty',
        'cost_price',
        'total',
    ];

    /**
     * Item belongs to PO
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    /**
     * Item belongs to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}