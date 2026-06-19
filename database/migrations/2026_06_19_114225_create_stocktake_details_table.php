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
        Schema::create('stocktake_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stocktake_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('batch_number')->nullable();
            $table->date('expiry_date')->nullable();

            $table->decimal('system_quantity', 12, 2); // Số lượng trên phần mềm tại thời điểm chốt phiếu
            $table->decimal('actual_quantity', 12, 2); // Số lượng thực tế thủ kho đếm được
            $table->decimal('adjustment_quantity', 12, 2); // Lượng chênh lệch (actual - system) để tăng/giảm kho
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocktakes_details');
    }
};
