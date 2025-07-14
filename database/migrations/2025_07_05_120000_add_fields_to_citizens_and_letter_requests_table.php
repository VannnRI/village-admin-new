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
        Schema::table('citizens', function (Blueprint $table) {
            $table->string('nationality')->default('Indonesia')->after('job');
        });

        Schema::table('letter_requests', function (Blueprint $table) {
            $table->text('domicile_address')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('keperluan')->nullable();
            $table->string('deceased_name')->nullable();
            $table->integer('deceased_age')->nullable();
            $table->string('deceased_nik')->nullable();
            $table->string('deceased_gender')->nullable();
            $table->text('deceased_address')->nullable();
            $table->string('death_day')->nullable();
            $table->date('death_date')->nullable();
            $table->string('death_place')->nullable();
            $table->string('death_cause')->nullable();
            $table->string('phone')->nullable()->change();
            $table->integer('nomor_urut')->nullable()->after('letter_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->dropColumn('nationality');
        });

        Schema::table('letter_requests', function (Blueprint $table) {
            $table->dropColumn([
                'domicile_address',
                'keterangan',
                'keperluan',
                'deceased_name',
                'deceased_age',
                'deceased_nik',
                'deceased_gender',
                'deceased_address',
                'death_day',
                'death_date',
                'death_place',
                'death_cause',
                'nomor_urut',
            ]);
            $table->string('phone')->nullable(false)->change();
        });
    }
}; 