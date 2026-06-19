<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'warehouse_id',
        'product_id',
        'batch_number',
        'expiry_date',
        'quantity',
        'cost_price',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
