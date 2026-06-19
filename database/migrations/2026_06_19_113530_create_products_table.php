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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->index(); // Mã sản phẩm
            $table->string('barcode')->nullable(); // Mã vạch phục vụ quét kiểm kho
            $table->string('name');
            $table->string('unit')->default('Cái'); // Đơn vị tính cơ bản (Gốc)
            $table->decimal('purchase_price', 15, 2)->default(0); // Giá mua định biên
            $table->decimal('sale_price', 15, 2)->default(0); // Giá bán định biên
            $table->decimal('min_stock', 12, 2)->default(0); // Định mức tồn tối thiểu để cảnh báo
            $table->decimal('max_stock', 12, 2)->default(0); // Định mức tồn tối đa
            $table->boolean('manage_by_batch')->default(false); // Có quản lý theo Lô/Hạn sử dụng không?
            $table->timestamps();

            $table->unique(['user_id', 'sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
