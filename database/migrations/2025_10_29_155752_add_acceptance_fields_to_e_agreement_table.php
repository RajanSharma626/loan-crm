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
            $table->string('acceptance_token', 64)->nullable()->unique()->after('application_number');
            $table->timestamp('token_expires_at')->nullable()->after('acceptance_token');
            $table->string('signature')->nullable()->after('token_expires_at');
            $table->string('acceptance_place')->nullable()->after('signature');
            $table->string('acceptance_ip')->nullable()->after('acceptance_place');
            $table->timestamp('acceptance_date')->nullable()->after('acceptance_ip');
            $table->boolean('is_accepted')->default(false)->after('acceptance_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('e_agreement', function (Blueprint $table) {
            $table->dropColumn([
                'acceptance_token',
                'token_expires_at',
                'signature',
                'acceptance_place',
                'acceptance_ip',
                'acceptance_date',
                'is_accepted'
            ]);
        });
    }
};
