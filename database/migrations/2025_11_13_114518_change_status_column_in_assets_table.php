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
        Schema::table('assets', function (Blueprint $table) {
            $table->string('status')->default('Ready')->change();
        });

        Schema::table('instrument_sets', function (Blueprint $table) {
            $table->string('status')->default('Ready')->after('qr_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active')->change();
        });

        Schema::table('instrument_sets', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
