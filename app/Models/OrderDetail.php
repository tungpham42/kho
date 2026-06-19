<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'batch_number',
        'expiry_date',
        'quantity',
        'unit_name',
        'base_quantity',
        'price',
        'total',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
