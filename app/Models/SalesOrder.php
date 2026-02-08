<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_date',
        'order_no',
        'total_amount',
        'status',
    ];

    /**
     * Sales Order belongs to Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Sales Order has many items
     */
    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }
}
