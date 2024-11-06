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
        Schema::create('commision_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_detail_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('provision_receipt')->nullable();

            $table->string('gross_premium')->nullable();
            $table->string('discount')->nullable();
            $table->string('net_discounted')->nullable();
            $table->string('amount_due_to_provider')->nullable();
            $table->string('full_commission')->nullable();

            $table->string('marketing_fund')->nullable();
            $table->string('offsetting')->nullable();
            $table->string('promo')->nullable();
            $table->string('total_commission')->nullable();

            $table->string('vat')->nullable();
            $table->string('sales_credit')->nullable();
            $table->string('sales_credit_percent')->nullable();
            $table->string('comm_deduct')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commision_details');
    }
};
