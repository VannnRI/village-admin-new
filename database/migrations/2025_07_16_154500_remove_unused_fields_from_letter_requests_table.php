<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->dropColumn(['keterangan', 'keperluan', 'domicile_address', 'letter_file']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->text('keterangan')->nullable();
            $table->text('keperluan')->nullable();
            $table->text('domicile_address')->nullable();
            $table->string('letter_file')->nullable();
        });
    }
};
