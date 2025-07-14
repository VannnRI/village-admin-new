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
        Schema::create('village_officials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('village_id');
            $table->string('position'); // Jabatan, misal: Sekretaris, Bendahara, dsb
            $table->string('name'); // Nama perangkat desa
            $table->string('nip')->nullable(); // NIP, opsional
            $table->timestamps();

            $table->foreign('village_id')->references('id')->on('villages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_officials');
    }
};
