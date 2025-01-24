<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ap_agings', function (Blueprint $table) {
            $table->id(); // Primary key field
            $table->foreignId('insurance_detail_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('assured_name')->nullable(); // Nullable string field
            $table->foreignId('provider_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key to provider table (nullable)
            $table->string('remittance_number')->nullable(); // Nullable string field
            $table->string('policy_number')->nullable(); // Nullable string field
            $table->string('due_date_start')->nullable(); // Nullable string field (for storing date as string)
            $table->string('due_date_end')->nullable(); // Nullable string field (for storing date as string)
            $table->string('terms')->nullable(); // Nullable string field
            $table->string('due_to_provider')->nullable(); // Nullable string field
            $table->string('total_outstanding')->nullable(); // Nullable string field
            $table->string('balance')->nullable(); // Nullable string field
            $table->string('first_payment')->nullable(); // Nullable string field
            $table->string('second_payment')->nullable(); // Nullable string field
            $table->string('total_payment')->nullable(); // Nullable string field
            $table->string('status')->nullable(); // Nullable string field
            $table->timestamps(); // Created at and updated at fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('ap_agings');
    }
};
