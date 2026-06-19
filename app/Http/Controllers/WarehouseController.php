<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $query = Warehouse::latest();

        // Kiểm tra xem có tham số 'search' được gửi lên hay không
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('code', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('name', 'LIKE', '%' . $searchTerm . '%');
        }

        $warehouses = $query->get();
        return view('warehouses.index', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        Warehouse::create($validated);
        return back()->with('success', 'Thêm kho hàng thành công!');
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $warehouse->update($validated);
        return back()->with('success', 'Cập nhật kho thành công!');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return back()->with('success', 'Đã xóa kho hàng!');
    }
}
