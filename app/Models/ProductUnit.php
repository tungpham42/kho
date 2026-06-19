<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    protected $fillable = [
        'product_id',
        'unit_name',
        'operator_value',
        'operator',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
