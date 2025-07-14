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
        Schema::create('letter_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->onDelete('cascade');
            $table->foreignId('citizen_id')->constrained()->onDelete('cascade');
            $table->foreignId('letter_type_id')->constrained()->onDelete('cascade');
            $table->string('request_number')->unique();
            $table->string('letter_name');
            $table->string('applicant_name');
            $table->string('applicant_nik', 16);
            $table->string('applicant_kk', 16);
            $table->text('purpose');
            $table->string('phone');
            $table->text('address');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('letter_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_requests');
    }
};
