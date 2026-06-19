<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'code',
        'from_warehouse_id',
        'to_warehouse_id',
        'transfer_date',
        'status',
        'note',
    ];

    protected $casts = [
        'transfer_date' => 'datetime',
    ];

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function details()
    {
        return $this->hasMany(StockTransferDetail::class);
    }
}
