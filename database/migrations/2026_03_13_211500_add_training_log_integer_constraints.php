<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Enforce 32-bit integer bounds at the DB level
        DB::statement("
            ALTER TABLE training_logs
            ADD CONSTRAINT training_logs_distance_int_range
            CHECK (distance IS NULL OR (distance >= 1 AND distance <= 2147483647))
        ");

        DB::statement("
            ALTER TABLE training_logs
            ADD CONSTRAINT training_logs_arrow_count_int_range
            CHECK (arrow_count IS NULL OR (arrow_count >= 1 AND arrow_count <= 2147483647))
        ");

        DB::statement("
            ALTER TABLE training_logs
            ADD CONSTRAINT training_logs_total_score_int_range
            CHECK (total_score IS NULL OR (total_score >= 0 AND total_score <= 2147483647))
        ");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE training_logs DROP CONSTRAINT IF EXISTS training_logs_distance_int_range");
        DB::statement("ALTER TABLE training_logs DROP CONSTRAINT IF EXISTS training_logs_arrow_count_int_range");
        DB::statement("ALTER TABLE training_logs DROP CONSTRAINT IF EXISTS training_logs_total_score_int_range");
    }
};
