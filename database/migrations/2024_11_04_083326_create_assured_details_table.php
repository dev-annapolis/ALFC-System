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
        Schema::create('assured_details', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();

            $table->string('lot_number')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();

            $table->string('other_contact_number')->nullable();
            $table->string('facebook_account')->nullable();
            $table->string('viber_account')->nullable();
            $table->string('nature_of_business')->nullable();
            $table->string('other_assets')->nullable();
            $table->string('other_source_of_business')->nullable();

            $table->string('primary_reference')->nullable();
            $table->string('verified_number')->nullable();
            $table->string('verified_mailing_address')->nullable();
            $table->string('customer_care_remarks')->nullable();
            $table->string('additional_reference')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assured_details');
    }
};
