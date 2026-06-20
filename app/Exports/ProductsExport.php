<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $isTemplate;

    public function __construct($isTemplate = false)
    {
        $this->isTemplate = $isTemplate;
    }

    public function collection()
    {
        // Nếu là tải file mẫu, trả về collection rỗng
        if ($this->isTemplate) {
            return collect([]);
        }

        return Product::all();
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Tên Sản Phẩm',
            'Đơn Vị',
            'Giá Mua',
            'Giá Bán'
        ];
    }

    public function map($product): array
    {
        return [
            $product->sku,
            $product->name,
            $product->unit,
            $product->purchase_price,
            $product->sale_price,
        ];
    }
}
