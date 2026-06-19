<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'type',
        'code',
        'name',
        'mst',
        'phone',
        'email',
        'address',
        'opening_debt',
    ];
}
