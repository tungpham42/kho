<?php

namespace App\Http\Controllers;

use App\Models\StockTransfer;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransferController extends Controller
{
    public function index()
    {
        $transfers = StockTransfer::with(['fromWarehouse', 'toWarehouse'])->latest()->get();
        return view('transfers.index', compact('transfers'));
    }

    public function create()
    {
        // Lấy danh sách kho và sản phẩm
        $warehouses = Warehouse::where('is_active', true)->get();
        $products = Product::latest()->get();

        return view('transfers.create', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_warehouse_id' => 'required|exists:warehouses,id|different:to_warehouse_id',
            'to_warehouse_id' => 'required|exists:warehouses,id',
            'transfer_date' => 'required|date',
            'details' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $transfer = StockTransfer::create([
                'code' => 'TRF-' . time(),
                'from_warehouse_id' => $request->from_warehouse_id,
                'to_warehouse_id' => $request->to_warehouse_id,
                'transfer_date' => $request->transfer_date,
                'status' => 'pending',
            ]);

            foreach ($request->details as $item) {
                $transfer->details()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    // Lấy batch_number / expiry_date nếu hệ thống bạn có nhập
                ]);
            }
        });

        return redirect()->route('transfers.index')->with('success', 'Tạo phiếu chuyển kho thành công!');
    }

    public function approve(StockTransfer $transfer)
    {
        if ($transfer->status !== 'pending') {
            return back()->withErrors('Chỉ có thể duyệt phiếu đang chờ!');
        }

        try {
            DB::transaction(function () use ($transfer) {
                $transfer->update(['status' => 'completed']);

                foreach ($transfer->details as $detail) {
                    // 1. Kiểm tra và trừ kho xuất
                    $fromInv = Inventory::firstOrNew([
                        'warehouse_id' => $transfer->from_warehouse_id,
                        'product_id' => $detail->product_id,
                        'batch_number' => $detail->batch_number,
                        'expiry_date' => $detail->expiry_date,
                    ]);

                    // Lấy luôn tên sản phẩm ra báo lỗi cho thân thiện thay vì báo mỗi ID
                    if ($fromInv->quantity < $detail->quantity) {
                        $productName = $detail->product->name ?? 'ID ' . $detail->product_id;
                        throw new \Exception("Sản phẩm [{$productName}] không đủ tồn kho tại kho xuất! (Tồn hệ thống: {$fromInv->quantity})");
                    }

                    $fromInv->quantity -= $detail->quantity;
                    $fromInv->save();

                    // 2. Cộng kho nhập
                    $toInv = Inventory::firstOrNew([
                        'warehouse_id' => $transfer->to_warehouse_id,
                        'product_id' => $detail->product_id,
                        'batch_number' => $detail->batch_number,
                        'expiry_date' => $detail->expiry_date,
                    ]);

                    $toInv->quantity += $detail->quantity;
                    $toInv->save();
                }
            });

            return back()->with('success', 'Đã duyệt phiếu chuyển kho thành công!');

        } catch (\Exception $e) {
            // Bắt lỗi và trả về giao diện bằng SweetAlert2
            return back()->withErrors($e->getMessage());
        }
    }
}
