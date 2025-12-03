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
            // Drop old single remarks field if it exists
            if (Schema::hasColumn('documents', 'remarks')) {
                $table->dropColumn('remarks');
            }
            
            // Add separate remarks fields for each document type
            $table->text('photograph_remarks')->nullable()->after('photograph_status');
            $table->text('pan_card_remarks')->nullable()->after('pan_card_status');
            $table->text('adhar_card_remarks')->nullable()->after('adhar_card_status');
            $table->text('current_address_remarks')->nullable()->after('current_address_status');
            $table->text('permanent_address_remarks')->nullable()->after('permanent_address_status');
            $table->text('salary_slip_remarks')->nullable()->after('salary_slip_status');
            $table->text('bank_statement_remarks')->nullable()->after('bank_statement_status');
            $table->text('cibil_remarks')->nullable()->after('cibil_status');
            $table->text('other_documents_remarks')->nullable()->after('other_documents_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn([
                'photograph_remarks',
                'pan_card_remarks',
                'adhar_card_remarks',
                'current_address_remarks',
                'permanent_address_remarks',
                'salary_slip_remarks',
                'bank_statement_remarks',
                'cibil_remarks',
                'other_documents_remarks'
            ]);
        });
    }
};
