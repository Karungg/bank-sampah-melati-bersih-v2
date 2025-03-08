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
        Schema::create('with_drawals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('with_drawal_code', 16)->unique();
            $table->foreignUuid('customer_id')->constrained();
            $table->decimal('amount', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('with_drawals');
    }
};
