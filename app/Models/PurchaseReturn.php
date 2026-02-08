<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'return_no',
        'return_date',
        'total',
        'note',
    ];

    /**
     * A Purchase Return belongs to ONE Purchase (GRN)
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * A Purchase Return has MANY returned items
     */
    public function items()
    {
        return $this->hasMany(PurchaseReturnItem::class);
    }
}