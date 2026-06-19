<?php

namespace App\Http\Controllers;

use App\Models\Stocktake;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StocktakeController extends Controller
{
    public function index()
    {
        $stocktakes = Stocktake::with('warehouse')->latest()->get();
        return view('stocktakes.index', compact('stocktakes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'stocktake_date' => 'required|date',
            'details' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $stocktake = Stocktake::create([
                'warehouse_id' => $request->warehouse_id,
                'code' => 'STK-' . time(),
                'stocktake_date' => $request->stocktake_date,
                'status' => 'draft',
            ]);

            foreach ($request->details as $item) {
                $stocktake->details()->create([
                    'product_id' => $item['product_id'],
                    'batch_number' => $item['batch_number'] ?? null,
                    'expiry_date' => $item['expiry_date'] ?? null,
                    'system_quantity' => $item['system_quantity'],
                    'actual_quantity' => $item['actual_quantity'],
                    'adjustment_quantity' => $item['actual_quantity'] - $item['system_quantity'],
                ]);
            }
        });

        return back()->with('success', 'Tạo phiếu kiểm kê thành công!');
    }

    public function approve(Stocktake $stocktake)
    {
        if ($stocktake->status !== 'draft') return back()->withErrors('Phiếu đã được cân bằng!');

        DB::transaction(function () use ($stocktake) {
            $stocktake->update(['status' => 'adjusted']);

            foreach ($stocktake->details as $detail) {
                // Cập nhật tồn kho theo số lượng thực tế đếm được
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
}
