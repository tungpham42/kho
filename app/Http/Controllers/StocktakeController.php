<?php

namespace App\Http\Controllers;

use App\Models\Stocktake;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Setting; // Thêm Model Setting
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StocktakeController extends Controller
{
    public function index(Request $request)
    {
        $query = Stocktake::with('warehouse')->latest();

        if ($request->filled('search')) {
            $query->where('code', 'LIKE', '%' . $request->search . '%');
        }

        $stocktakes = $query->get();
        return view('stocktakes.index', compact('stocktakes'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('is_active', 1)->get();
        $products = Product::all();

        return view('stocktakes.create', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'stocktake_date' => 'required|date',
            'details' => 'required|array',
        ]);

        // Lấy cấu hình tiền tố
        $setting = Setting::first();
        $prefix = $setting ? $setting->stocktake_prefix : 'STK-';

        DB::transaction(function () use ($request, $prefix) {
            $status = $request->action === 'complete' ? 'completed' : 'pending';

            $stocktake = Stocktake::create([
                'warehouse_id' => $request->warehouse_id,
                'code' => $prefix . strtoupper(uniqid()), // Áp dụng tiền tố
                'stocktake_date' => $request->stocktake_date,
                'status' => $status,
                'note' => $request->note ?? null,
            ]);

            foreach ($request->details as $item) {
                $systemQty = $item['system_qty'] ?? 0;
                $actualQty = $item['actual_qty'] ?? 0;

                $stocktake->details()->create([
                    'product_id' => $item['product_id'],
                    'batch_number' => $item['batch_number'] ?? null,
                    'expiry_date' => $item['expiry_date'] ?? null,
                    'system_quantity' => $systemQty,
                    'actual_quantity' => $actualQty,
                    'adjustment_quantity' => $actualQty - $systemQty,
                ]);

                if ($status === 'completed') {
                    Inventory::updateOrCreate(
                        [
                            'warehouse_id' => $stocktake->warehouse_id,
                            'product_id' => $item['product_id'],
                            'batch_number' => $item['batch_number'] ?? null,
                            'expiry_date' => $item['expiry_date'] ?? null,
                        ],
                        ['quantity' => $actualQty]
                    );
                }
            }
        });

        return redirect()->route('stocktakes.index')->with('success', 'Tạo phiếu kiểm kê thành công!');
    }

    public function approve(Stocktake $stocktake)
    {
        if ($stocktake->status !== 'pending') {
            return back()->withErrors('Phiếu này đã được cân bằng trước đó!');
        }

        DB::transaction(function () use ($stocktake) {
            $stocktake->update(['status' => 'completed']);

            foreach ($stocktake->details as $detail) {
                Inventory::updateOrCreate(
                    [
                        'warehouse_id' => $stocktake->warehouse_id,
                        'product_id' => $detail->product_id,
                        'batch_number' => $detail->batch_number,
                        'expiry_date' => $detail->expiry_date,
                    ],
                    ['quantity' => $detail->actual_quantity]
                );
            }
        });

        return back()->with('success', 'Đã cân bằng kho theo số lượng thực tế!');
    }

    public function destroy(Stocktake $stocktake)
    {
        $stocktake->delete();
        return back()->with('success', 'Đã xóa phiếu kiểm kê!');
    }
}
