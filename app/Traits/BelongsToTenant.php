<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        // Hàm lấy ID của Tenant hiện tại
        $getTenantId = function () {
            if (auth('web')->check()) {
                return auth('web')->id(); // Nếu là chủ doanh nghiệp
            }
            if (auth('employee')->check()) {
                return auth('employee')->user()->user_id; // Nếu là nhân viên, lấy user_id (ID chủ)
            }
            return null;
        };

        static::addGlobalScope('tenant', function (Builder $builder) use ($getTenantId) {
            $tenantId = $getTenantId();
            if ($tenantId) {
                $builder->where($builder->getModel()->getTable() . '.user_id', $tenantId);
            }
        });

        static::creating(function ($model) use ($getTenantId) {
            $tenantId = $getTenantId();
            if ($tenantId) {
                $model->user_id = $tenantId;
            }
        });
    }
}
