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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('batch_number')->nullable(); // Số lô (Nếu có)
            $table->date('expiry_date')->nullable(); // Hạn sử dụng (Nếu có)
            $table->decimal('quantity', 12, 2)->default(0); // Số lượng tồn thực tế
            $table->decimal('cost_price', 15, 2)->default(0); // Giá vốn phục vụ tính FIFO/Bình quân
            $table->timestamps();

            // Index để tăng tốc độ truy vấn báo cáo Xuất Nhập Tồn
            $table->index(['warehouse_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
