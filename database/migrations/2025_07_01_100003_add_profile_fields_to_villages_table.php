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
        Schema::table('villages', function (Blueprint $table) {
            if (!Schema::hasColumn('villages', 'postal_code')) {
                $table->string('postal_code')->nullable();
            }
            if (!Schema::hasColumn('villages', 'village_code')) {
                $table->string('village_code')->nullable();
            }
            if (!Schema::hasColumn('villages', 'number_format')) {
                $table->string('number_format')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('villages', function (Blueprint $table) {
            if (Schema::hasColumn('villages', 'postal_code')) {
                $table->dropColumn('postal_code');
            }
            if (Schema::hasColumn('villages', 'village_code')) {
                $table->dropColumn('village_code');
            }
            if (Schema::hasColumn('villages', 'number_format')) {
                $table->dropColumn('number_format');
            }
        });
    }
};
