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
        Schema::table('faculties', function (Blueprint $table) {
            $table->index(['is_archived', 'full_name'], 'idx_faculties_active_name');
        });
        Schema::table('rooms', function (Blueprint $table) {
            $table->index(['is_archived', 'room_number'], 'idx_rooms_active_number');
        });
        Schema::table('subjects', function (Blueprint $table) {
            $table->index(['program_id', 'year_level', 'semester'], 'idx_subjects_program_year_sem');
        });
    }

    public function down(): void
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->dropIndex('idx_faculties_active_name');
        });
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropIndex('idx_rooms_active_number');
        });
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropIndex('idx_subjects_program_year_sem');
        });
    }
};
