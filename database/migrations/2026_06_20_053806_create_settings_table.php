<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // Thông tin doanh nghiệp
            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_address')->nullable();

            // Cấu hình Prefix (Tiền tố mã chứng từ)
            $table->string('order_prefix')->default('ORD-');
            $table->string('transfer_prefix')->default('TRF-');
            $table->string('stocktake_prefix')->default('STK-');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
