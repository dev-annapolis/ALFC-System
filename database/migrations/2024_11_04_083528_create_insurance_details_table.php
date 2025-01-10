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
        Schema::create('insurance_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assured_detail_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('issuance_code');

            $table->foreignId('team_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('sales_associate_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('sales_manager_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('regional_manager_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('sale_date')->nullable();
            $table->string('classification');
            $table->string('insurance_status')->default('Sale'); // Sale,Cancellation,Reinstatement
            
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('subproduct_id')->nullable()->constrained()->onDelete('cascade');
            
            $table->foreignId('source_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('source_branch_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('source_division_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('mortgagee')->nullable();
            $table->foreignId('area_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('alfc_branch_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('loan_amount')->nullable();
            $table->string('total_sum_insured')->nullable();
            $table->string('policy_inception_date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('plate_conduction_number')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('mode_of_payment_id')->nullable()->constrained()->onDelete('cascade');
            
            $table->string('ra_comments')->nullable();
            $table->string('admin_assistant_remarks')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('mode_of_delivery')->nullable();

            $table->string('policy_received_by')->nullable(); //DB
            $table->string('policy_expiration_aging')->nullable(); // Formlated
            $table->string('book_number')->nullable();  //DB
            $table->string('filing_number')->nullable();  //DB
            $table->string('database_remarks')->nullable();  //DB
            $table->string('pid_received_date')->nullable();  //DB
            $table->string('pid_status')->nullable();  //DB
            $table->string('pid_completion_date')->nullable();  //DB

            $table->string('verification_status')->default('for_ra_verification');

            $table->timestamps();
            
            // LILIPAT SA PAYMENT DEAILS
            $table->foreignId('provider_id')->nullable()->constrained()->onDelete('cascade');

            // AALISIN
            $table->string('product_type')->nullable();
            $table->foreignId('if_gdfi_id')->nullable()->constrained()->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_details');
    }
};
