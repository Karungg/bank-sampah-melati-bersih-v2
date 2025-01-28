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
        Schema::create('weighted_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('total_quantity')->nullable();
            $table->decimal('total_weight', 12, 2)->nullable();
            $table->decimal('total_liter', 12, 2)->nullable();
            $table->foreignUuid('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weighted_products');
    }
};
