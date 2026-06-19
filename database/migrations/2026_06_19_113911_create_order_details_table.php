<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('batch_number')->nullable();
            $table->date('expiry_date')->nullable();

            $table->decimal('quantity', 12, 2); // Số lượng theo đơn vị tính lúc chọn
            $table->string('unit_name'); // Tên đơn vị lúc chọn (Lưu text để giữ lịch sử nếu danh mục đổi)
            $table->decimal('base_quantity', 12, 2); // Số lượng đã quy đổi ra đơn vị gốc để tính kho

            $table->decimal('price', 15, 2); // Đơn giá sản phẩm
            $table->decimal('total', 15, 2); // Thành tiền mặt hàng này
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
