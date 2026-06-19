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
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('code')->index(); // Mã phiếu chuyển kho (VD: DCK001)
            $table->foreignId('from_warehouse_id')->constrained('warehouses')->cascadeOnDelete(); // Kho đi
            $table->foreignId('to_warehouse_id')->constrained('warehouses')->cascadeOnDelete(); // Kho đến
            $table->timestamp('transfer_date');
            $table->string('status')->default('pending'); // pending, completed, cancelled
            $table->string('note')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfers');
    }
};
