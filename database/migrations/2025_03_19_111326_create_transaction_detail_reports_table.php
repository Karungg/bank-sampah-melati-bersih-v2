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
        Schema::create('transaction_detail_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('quantity')->nullable();
            $table->decimal('weight', 12, 2)->nullable();
            $table->decimal('liter', 12, 2)->nullable();
            $table->decimal('current_price', 12, 2)->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->char('transaction_id');
            $table->char('product_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_detail_reports');
    }
};
