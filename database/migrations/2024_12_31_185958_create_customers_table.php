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
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nik', 16)->unique();
            $table->string('full_name', 100);
            $table->string('place_of_birth', 50);
            $table->date('date_of_birth');
            $table->string('phone', 14);
            $table->text('address');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('village', 100);
            $table->string('district', 100);
            $table->string('city', 100);
            $table->string('postal_code', 5);
            $table->string('identity_card_photo', 255)->nullable();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
