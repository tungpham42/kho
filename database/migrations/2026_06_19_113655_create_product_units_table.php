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
        Schema::create('product_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('unit_name'); // Tên đơn vị quy đổi (VD: Thùng)
            $table->decimal('operator_value', 12, 2); // Giá trị quy đổi (VD: 24)
            $table->enum('operator', ['multiply', 'divide'])->default('multiply'); // Nhân hay chia với đơn vị gốc
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_units');
    }
};
