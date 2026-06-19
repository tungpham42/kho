<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\Setting;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with(['warehouse', 'product']);

        // Bộ lọc theo kho
        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        // Bộ lọc theo từ khóa (Tìm qua bảng products: SKU, Tên sản phẩm)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('product', function ($q) use ($searchTerm) {
                $q->where('sku', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('name', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $inventories = $query->latest()->get();

        // Lấy danh sách kho bãi đang hoạt động để đưa vào bộ lọc Dropdown
        $warehouses = Warehouse::where('is_active', 1)->get();

        return view('inventories.index', compact('inventories', 'warehouses'));
    }
}
