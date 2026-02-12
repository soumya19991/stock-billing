<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'unit_id',
        'name',
        'sku',
        'price',
        'alert_qty',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function latestPrice()
    {
        return $this->hasOne(ProductPrice::class)->latestOfMany();
    }

    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
