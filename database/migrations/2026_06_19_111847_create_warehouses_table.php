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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Multi-tenancy
            $table->string('code')->index(); // Mã kho (VD: KHO-HCM)
            $table->string('name'); // Tên kho
            $table->string('address')->nullable(); // Địa chỉ kho
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Tránh trùng mã kho trong cùng 1 doanh nghiệp
            $table->unique(['user_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
