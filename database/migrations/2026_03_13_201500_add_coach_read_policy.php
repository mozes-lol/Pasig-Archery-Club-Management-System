<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Allow all authenticated users to read coaches for selection lists (RLS still enforces updates).
        DB::statement("
            CREATE POLICY coach_read_all_policy
            ON coaches
            FOR SELECT
            USING (true)
        ");
    }

    public function down(): void
    {
        DB::statement("DROP POLICY IF EXISTS coach_read_all_policy ON coaches");
    }
};
