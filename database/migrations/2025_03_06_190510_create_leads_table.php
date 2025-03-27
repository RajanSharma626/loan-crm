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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('lead_source')->nullable();
            $table->string('keyword')->nullable();
            $table->string('loan_type')->nullable();
            $table->string('city')->nullable();
            $table->integer('monthly_salary')->nullable();
            $table->integer('loan_amount')->nullable();
            $table->integer('duration')->nullable(); // in days
            $table->string('pancard_number')->unique()->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('education')->nullable();
            $table->string('disposition')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
