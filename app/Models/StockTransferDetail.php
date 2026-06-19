<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransferDetail extends Model
{
    protected $fillable = [
        'stock_transfer_id',
        'product_id',
        'batch_number',
        'expiry_date',
        'quantity',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
