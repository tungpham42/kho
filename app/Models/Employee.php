<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Quan trọng
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'roles',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Khai báo danh sách các Role có sẵn cho hệ thống
    public const AVAILABLE_ROLES = [
        'manage_products' => 'Quản lý Sản phẩm',
        'manage_orders' => 'Quản lý Đơn hàng',
        'manage_inventory' => 'Quản lý Tồn kho',
        'view_reports' => 'Xem Báo cáo',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'roles' => 'array', // Tự động convert JSON thành Array
        ];
    }

    // Quan hệ ngược lại với Tenant (Chủ doanh nghiệp)
    public function tenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
