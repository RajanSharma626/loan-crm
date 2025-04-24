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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->json('pan_card')->nullable();
            $table->json('photograph')->nullable();
            $table->json('adhar_card')->nullable();
            $table->json('current_address')->nullable();
            $table->json('permanent_address')->nullable();
            $table->json('salary_slip')->nullable();
            $table->json('bank_statement')->nullable();
            $table->json('cibil')->nullable();
            $table->json('other_documents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
