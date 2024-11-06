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
        Schema::create('collection_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_detail_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('insurance_type')->nullable();
            $table->string('sale_status')->nullable();

            $table->foreignId('tele_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('due_date')->nullable();
            $table->string('paid_terms')->nullable();
            $table->string('payment_remarks')->nullable();
            $table->string('account_status')->nullable();
            $table->string('payment_ptp_declared')->nullable();
            $table->string('payment_center')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('date_on_receipt_abstract')->nullable();
            $table->string('contact_number_verification')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_details');
    }
};
