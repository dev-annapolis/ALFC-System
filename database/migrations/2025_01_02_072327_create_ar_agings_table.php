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
        Schema::create('ar_agings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_detail_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('issuance_code')->nullable();
            $table->string('name')->nullable();
            $table->string('due_date_start')->nullable();
            $table->string('due_date_end')->nullable();
            $table->string('terms')->nullable();
            $table->string('team')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('sale_date')->nullable();
            $table->string('mode_of_payment')->nullable();
            $table->string('gross_premium')->nullable();
            $table->string('total_outstanding')->nullable();
            $table->string('aging_due_days')->nullable();//not sure 
            $table->string('aging_description')->nullable();//not sure 
            $table->string('last_paid_date')->nullable();//not sure 
            $table->string('balance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ar_agings');
    }
};
