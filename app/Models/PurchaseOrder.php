<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_no',
        'vendor_id',
        'po_date',
        'status',
        'total',
        'note',
    ];

    /**
     * PO belongs to one Vendor
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * PO has many items
     */
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}