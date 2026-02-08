<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'gst_no',
        'status',
    ];

    /**
     * Customer can have many Sales Orders
     */
    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }

    /**
     * Customer can have many Sales Invoices
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Customer can have many Sales Returns
     */
    public function salesReturns()
    {
        return $this->hasMany(SalesReturn::class);
    }
}