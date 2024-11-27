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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_detail_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('payment_terms')->nullable();
            $table->string('due_date_start')->nullable();
            $table->string('due_date_end')->nullable();

            $table->string('first_payment_schedule')->nullable();
            $table->string('first_payment_amount')->nullable();

            $table->string('second_payment_schedule')->nullable();
            $table->string('second_payment_amount')->nullable();

            $table->string('third_payment_schedule')->nullable();
            $table->string('third_payment_amount')->nullable();

            $table->string('fourth_payment_schedule')->nullable();
            $table->string('fourth_payment_amount')->nullable();

            $table->string('fifth_payment_schedule')->nullable();
            $table->string('fifth_payment_amount')->nullable();

            $table->string('sixth_payment_schedule')->nullable();
            $table->string('sixth_payment_amount')->nullable();

            $table->string('seventh_payment_schedule')->nullable();
            $table->string('seventh_payment_amount')->nullable();

            $table->string('eight_payment_schedule')->nullable();
            $table->string('eight_payment_amount')->nullable();

            $table->string('provision_receipt')->nullable();

            $table->string('initial_payment')->nullable();
            $table->string('for_billing')->nullable();
            $table->string('over_under_payment')->nullable();
        
            $table->string('date_of_good_as_sales')->nullable();
            $table->string('payment_status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
