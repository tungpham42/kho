<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Bắt đầu khởi tạo query
        $query = Product::with('units')->latest();

        // Kiểm tra xem có tham số 'search' được gửi lên hay không
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('sku', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('name', 'LIKE', '%' . $searchTerm . '%');
        }

        // Thực thi query và lấy kết quả
        $products = $query->get();

        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::create($request->only(['sku', 'barcode', 'name', 'unit', 'purchase_price', 'sale_price', 'min_stock', 'max_stock', 'manage_by_batch']));

            // Xử lý lưu các đơn vị quy đổi (nếu có) từ form gửi lên
            if ($request->has('units') && is_array($request->units)) {
                $product->units()->createMany($request->units);
            }
        });

        return back()->with('success', 'Thêm sản phẩm thành công!');
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->except('units'));
        // Xử lý cập nhật units nếu cần...
        return back()->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Đã xóa sản phẩm!');
    }
}
