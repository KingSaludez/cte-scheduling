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
        Schema::table('schedules', function (Blueprint $table) {
            $table->index(['day', 'academic_year', 'semester', 'start_time'], 'idx_matrix_query');
            $table->index('faculty_id');
            $table->index('room_id');
            $table->index('section_id');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropIndex('idx_matrix_query');
            $table->dropIndex(['faculty_id']);
            $table->dropIndex(['room_id']);
            $table->dropIndex(['section_id']);
        });
    }
};
