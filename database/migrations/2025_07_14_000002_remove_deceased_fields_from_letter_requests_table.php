<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->dropColumn([
                'deceased_name',
                'deceased_age',
                'deceased_nik',
                'deceased_gender',
                'deceased_address',
                'death_day',
                'death_date',
                'death_place',
                'death_cause',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->string('deceased_name')->nullable();
            $table->integer('deceased_age')->nullable();
            $table->string('deceased_nik')->nullable();
            $table->string('deceased_gender')->nullable();
            $table->text('deceased_address')->nullable();
            $table->string('death_day')->nullable();
            $table->date('death_date')->nullable();
            $table->string('death_place')->nullable();
            $table->string('death_cause')->nullable();
        });
    }
}; 