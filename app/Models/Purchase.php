<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'purchase_no',
        'purchase_date',
        'subtotal',
        'tax',
        'discount',
        'total',
        'note',
        'status',
    ];

    // A purchase belongs to one vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // A purchase has many purchase items
    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function returns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }
}
