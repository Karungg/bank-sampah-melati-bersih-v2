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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transaction_code', 16)->unique();
            $table->integer('total_quantity')->nullable();
            $table->decimal('total_weight', 12, 2)->nullable();
            $table->decimal('total_liter', 12, 2)->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->string('type', 20);
            $table->string('location', 255)->nullable();
            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('customer_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
