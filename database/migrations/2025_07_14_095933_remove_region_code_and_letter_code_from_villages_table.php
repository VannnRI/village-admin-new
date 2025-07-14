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
        \Schema::table('villages', function ($table) {
            $table->dropColumn(['region_code', 'letter_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Schema::table('villages', function ($table) {
            $table->string('region_code')->nullable();
            $table->string('letter_code')->nullable();
        });
    }
};
