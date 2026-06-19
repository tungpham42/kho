<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'sku',
        'barcode',
        'name',
        'unit',
        'purchase_price',
        'sale_price',
        'min_stock',
        'max_stock',
        'manage_by_batch',
    ];

    protected $casts = [
        'manage_by_batch' => 'boolean',
    ];

    public function units()
    {
        return $this->hasMany(ProductUnit::class);
    }
}
