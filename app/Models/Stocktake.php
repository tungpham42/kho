<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Stocktake extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'warehouse_id',
        'code',
        'stocktake_date',
        'status',
        'note',
    ];

    protected $casts = [
        'stocktake_date' => 'datetime',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function details()
    {
        return $this->hasMany(StocktakeDetail::class);
    }
}
