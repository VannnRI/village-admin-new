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
        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->string('kk_number', 16);
            $table->string('name');
            $table->date('birth_date');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('education')->nullable();
            $table->string('job')->nullable();
            $table->string('birth_place')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};
