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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete(); // Kho trực tiếp xử lý
            $table->foreignId('partner_id')->nullable()->constrained()->nullOnDelete(); // Nhà cung cấp hoặc Khách hàng

            $table->string('code')->index(); // Số phiếu tự động sinh (VD: PN001, PX001)
            $table->enum('type', ['import', 'export', 'supplier_return', 'customer_return']); // Loại chứng từ
            $table->timestamp('order_date'); // Ngày lập phiếu
            $table->decimal('total_amount', 15, 2)->default(0); // Tổng tiền hàng
            $table->decimal('discount', 15, 2)->default(0); // Chiết khấu thanh toán
            $table->decimal('final_amount', 15, 2)->default(0); // Tiền phải thanh toán sau cùng
            $table->string('note')->nullable(); // Ghi chú phiếu
            $table->string('status')->default('draft'); // draft (nháp), completed (đã duyệt/thực hiện), cancelled (hủy)
            $table->timestamps();

            $table->unique(['user_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
