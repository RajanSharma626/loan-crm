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
        Schema::table('e_agreement', function (Blueprint $table) {
            $table->date('closed_date')->nullable()->after('is_accepted');
            $table->decimal('received_amount', 15, 2)->nullable()->after('closed_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('e_agreement', function (Blueprint $table) {
            $table->dropColumn([
                'closed_date',
                'received_amount'
            ]);
        });
    }
};
