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
        Schema::table('documents', function (Blueprint $table) {
            $table->string('pan_card_status')->nullable()->after('pan_card');
            $table->string('photograph_status')->nullable()->after('photograph');
            $table->string('adhar_card_status')->nullable()->after('adhar_card');
            $table->string('current_address_status')->nullable()->after('current_address');
            $table->string('permanent_address_status')->nullable()->after('permanent_address');
            $table->string('salary_slip_status')->nullable()->after('salary_slip');
            $table->string('bank_statement_status')->nullable()->after('bank_statement');
            $table->string('cibil_status')->nullable()->after('cibil');
            $table->string('other_documents_status')->nullable()->after('other_documents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn([
                'pan_card_status',
                'photograph_status',
                'adhar_card_status',
                'current_address_status',
                'permanent_address_status',
                'salary_slip_status',
                'bank_statement_status',
                'cibil_status',
                'other_documents_status'
            ]);
        });
    }
};


