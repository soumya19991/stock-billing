<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_return_id',
        'product_id',
        'qty',
        'cost_price',
        'total',
    ];

    /**
     * Each item belongs to ONE return
     */
    public function purchaseReturn()
    {
        return $this->belongsTo(PurchaseReturn::class);
    }

    /**
     * Returned item belongs to ONE product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}