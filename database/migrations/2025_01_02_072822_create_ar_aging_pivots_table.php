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
        Schema::create('ar_aging_pivots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ar_aging_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('label')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('payment_schedule')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('paid_schedule')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('ra_remarks')->nullable();
            $table->string('tele_remarks')->nullable();
            $table->boolean('paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ar_aging_pivots');
    }
};
