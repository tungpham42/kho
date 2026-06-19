<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StocktakeDetail extends Model
{
    protected $fillable = [
        'stocktake_id',
        'product_id',
        'batch_number',
        'expiry_date',
        'system_quantity',
        'actual_quantity',
        'adjustment_quantity',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
