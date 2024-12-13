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
        Schema::create('insurance_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_detail_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('checklist_option_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_checklists');
    }
};
