<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('villages', function (Blueprint $table) {
            $table->string('region_code')->nullable()->after('village_code');
            $table->string('letter_code')->nullable()->after('region_code');
        });

        Schema::table('letter_types', function (Blueprint $table) {
        });
    }

    public function down(): void
    {
        Schema::table('villages', function (Blueprint $table) {
            $table->dropColumn(['region_code', 'letter_code']);
        });

        Schema::table('letter_types', function (Blueprint $table) {
        });
    }
}; 