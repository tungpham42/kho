<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Kiểm tra nếu dòng trống SKU thì bỏ qua
        if (!isset($row['sku']) || empty($row['sku'])) {
            return null;
        }

        return Product::updateOrCreate(
            ['sku' => $row['sku']],
            [
                'name'           => $row['ten_san_pham'],
                'unit'           => $row['don_vi'],
                'purchase_price' => $row['gia_mua'] ?? 0,
                'sale_price'     => $row['gia_ban'] ?? 0,
            ]
        );
    }
}
