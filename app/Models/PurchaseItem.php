<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'qty',
        'cost_price',
        'total',
    ];

    // Each item belongs to a purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // Each item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
