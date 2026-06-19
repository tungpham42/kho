<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Setting; // Thêm Model Setting
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['warehouse', 'partner'])->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'type' => 'required|in:import,export,supplier_return,customer_return',
            'order_date' => 'required|date',
            'details' => 'required|array',
        ]);

        // Lấy cấu hình tiền tố
        $setting = Setting::first();
        $prefix = $setting ? $setting->order_prefix : 'ORD-';

        DB::transaction(function () use ($request, $prefix) {
            // 1. Tạo phiếu gốc (Master)
            $order = Order::create([
                'warehouse_id' => $request->warehouse_id,
                'partner_id' => $request->partner_id,
                'code' => $prefix . time(), // Áp dụng tiền tố
                'type' => $request->type,
                'order_date' => $request->order_date,
                'status' => 'draft',
                'total_amount' => 0,
                'final_amount' => 0,
            ]);

            $totalAmount = 0;

            // 2. Lưu chi tiết hàng hóa (Details)
            foreach ($request->details as $item) {
                $lineTotal = $item['quantity'] * $item['price'];
                $totalAmount += $lineTotal;

                $order->details()->create([
                    'product_id' => $item['product_id'],
                    'unit_name' => $item['unit_name'],
                    'quantity' => $item['quantity'],
                    'base_quantity' => $item['base_quantity'] ?? $item['quantity'],
                    'price' => $item['price'],
                    'total' => $lineTotal,
                ]);
            }

            // 3. Cập nhật lại tổng tiền cho phiếu gốc
            $order->update([
                'total_amount' => $totalAmount,
                'final_amount' => $totalAmount,
            ]);
        });

        return redirect()->route('orders.index')->with('success', 'Tạo phiếu nháp thành công!');
    }

    public function approve(Order $order)
    {
        if ($order->status !== 'draft') {
            return back()->withErrors('Chỉ có thể duyệt phiếu nháp!');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'completed']);
            $isImport = in_array($order->type, ['import', 'customer_return']);
            $operator = $isImport ? 1 : -1;

            foreach ($order->details as $detail) {
                $inventory = Inventory::firstOrNew([
                    'warehouse_id' => $order->warehouse_id,
                    'product_id' => $detail->product_id,
                    'batch_number' => $detail->batch_number,
                    'expiry_date' => $detail->expiry_date,
                ]);

                $newQty = $inventory->quantity + ($detail->base_quantity * $operator);
                if (!$isImport && $newQty < 0) {
                    throw new \Exception("Mã hàng ID {$detail->product_id} không đủ tồn kho!");
                }

                $inventory->quantity = $newQty;
                $inventory->save();
            }
        });

        return back()->with('success', 'Duyệt phiếu và cập nhật tồn kho thành công!');
    }

    public function destroy(Order $order)
    {
        if ($order->status === 'completed') return back()->withErrors('Không thể xóa phiếu đã duyệt!');
        $order->delete();
        return back()->with('success', 'Đã xóa phiếu!');
    }

    public function create()
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $partners = Partner::latest()->get();
        $products = Product::latest()->get();

        return view('orders.create', compact('warehouses', 'partners', 'products'));
    }
}
