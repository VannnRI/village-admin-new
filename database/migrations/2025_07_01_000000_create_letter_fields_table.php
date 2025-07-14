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
        Schema::create('letter_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('village_id');
            $table->unsignedBigInteger('letter_type_id');
            $table->string('field_name');
            $table->string('field_label');
            $table->string('field_type')->default('text'); // text, number, date, select, radio, checkbox, textarea
            $table->text('field_options')->nullable(); // JSON/teks opsi untuk select/radio/checkbox
            $table->boolean('is_required')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('village_id')->references('id')->on('villages')->onDelete('cascade');
            $table->foreign('letter_type_id')->references('id')->on('letter_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_fields');
    }
}; 