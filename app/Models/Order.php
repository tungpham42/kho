<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'warehouse_id',
        'partner_id',
        'code',
        'type',
        'order_date',
        'total_amount',
        'discount',
        'final_amount',
        'note',
        'status',
    ];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
