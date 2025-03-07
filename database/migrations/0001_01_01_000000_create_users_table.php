<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile')->unique();
            $table->string('email')->unique();
            $table->string('lead_source')->nullable();
            $table->string('keyword')->nullable();
            $table->enum('loan_type', ['Personal Loan', 'Home Loan', 'Auto Loan'])->default('Personal Loan');
            $table->string('city');
            $table->integer('monthly_salary');
            $table->integer('loan_amount');
            $table->integer('duration'); // in days
            $table->string('pancard_number')->unique();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('dob');
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable();
            $table->string('education')->nullable();
            $table->enum('disposition', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('notes')->nullable();
            $table->string('agent_name')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leads');
    }
};
