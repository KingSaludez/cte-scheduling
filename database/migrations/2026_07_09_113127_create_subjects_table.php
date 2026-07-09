<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->decimal('units', 4, 1);
            $table->integer('lecture_hours')->default(0);
            $table->integer('lab_hours')->default(0);
            $table->integer('year_level');
            $table->enum('semester', ['1st', '2nd', 'summer']);
            $table->string('program')->nullable();
            $table->string('prerequisites')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
