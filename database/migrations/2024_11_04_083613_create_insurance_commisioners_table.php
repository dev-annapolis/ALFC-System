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
        Schema::create('insurance_commisioners', function (Blueprint $table) {
            $table->foreignId('insurance_detail_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('commisioner_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('commisioner_name')->nullable()->constrained()->onDelete('cascade');
            $table->string('amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_commisioners');
    }
};
