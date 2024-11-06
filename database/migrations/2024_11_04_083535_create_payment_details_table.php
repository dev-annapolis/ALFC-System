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
            $table->string('due_date')->nullable();

            $table->string('schedule_first_payment')->nullable();
            $table->string('schedule_second_payment')->nullable();
            $table->string('schedule_third_payment')->nullable();
            $table->string('schedule_fourth_payment')->nullable();
            $table->string('schedule_fifth_payment')->nullable();
            $table->string('schedule_sixth_payment')->nullable();
            $table->string('schedule_seventh_payment')->nullable();
            $table->string('schedule_eight_payment')->nullable();

            $table->string('for_billing')->nullable();
            $table->string('over_under_payment')->nullable();
            $table->string('initial_payment')->nullable();
            $table->string('good_as_sales_date')->nullable();
            $table->string('status')->nullable();

            $table->string('ra_comments')->nullable();
            $table->string('admin_assistant_remarks')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('policy_received_by')->nullable();

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
