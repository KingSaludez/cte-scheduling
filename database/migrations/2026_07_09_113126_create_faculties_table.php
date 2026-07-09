<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculties', function (Blueprint $table) {
            $table->id('faculty_id');
            $table->string('full_name');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('employment_status', ['full-time', 'part-time'])->default('full-time');
            $table->string('academic_rank')->nullable();
            $table->string('educational_attainment')->nullable();
            $table->string('professional_license')->nullable();
            $table->string('specialization')->nullable();
            $table->integer('max_load')->default(18);
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
