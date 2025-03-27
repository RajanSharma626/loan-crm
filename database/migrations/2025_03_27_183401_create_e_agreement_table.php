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
        Schema::create('e_agreement', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
            $table->string('disposition');
            $table->decimal('applied_amount', 15, 2)->nullable();
            $table->decimal('approved_amount', 15, 2);
            $table->integer('duration');
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('processing_fees', 15, 2)->nullable();
            $table->decimal('repayment_amount', 15, 2)->nullable();
            $table->decimal('disbursed_amount', 15, 2)->nullable();
            $table->string('application_number')->nullable();
            $table->string('customer_application_status');
            $table->string('signed_application')->nullable();
            $table->text('notes');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_agreement');
    }
};
