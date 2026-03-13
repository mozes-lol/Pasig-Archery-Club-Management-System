<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Allow coaches to read and update archer profiles
        DB::statement("
            CREATE POLICY archer_coach_select_policy
            ON archers
            FOR SELECT
            USING (
                EXISTS (
                    SELECT 1 FROM users
                    WHERE users.user_id = current_setting('app.current_user_id')::int
                    AND users.role_id = 2
                )
            )
        ");

        DB::statement("
            CREATE POLICY archer_coach_update_policy
            ON archers
            FOR UPDATE
            USING (
                EXISTS (
                    SELECT 1 FROM users
                    WHERE users.user_id = current_setting('app.current_user_id')::int
                    AND users.role_id = 2
                )
            )
            WITH CHECK (
                EXISTS (
                    SELECT 1 FROM users
                    WHERE users.user_id = current_setting('app.current_user_id')::int
                    AND users.role_id = 2
                )
            )
        ");

        // Allow coaches to assign achievements to archers
        DB::statement("
            CREATE POLICY user_achievements_coach_select_policy
            ON user_achievements
            FOR SELECT
            USING (
                EXISTS (
                    SELECT 1 FROM users
                    WHERE users.user_id = current_setting('app.current_user_id')::int
                    AND users.role_id = 2
                )
            )
        ");

        DB::statement("
            CREATE POLICY user_achievements_coach_insert_policy
            ON user_achievements
            FOR INSERT
            WITH CHECK (
                EXISTS (
                    SELECT 1 FROM users
                    WHERE users.user_id = current_setting('app.current_user_id')::int
                    AND users.role_id = 2
                )
            )
        ");
    }

    public function down(): void
    {
        DB::statement("DROP POLICY IF EXISTS archer_coach_select_policy ON archers");
        DB::statement("DROP POLICY IF EXISTS archer_coach_update_policy ON archers");
        DB::statement("DROP POLICY IF EXISTS user_achievements_coach_select_policy ON user_achievements");
        DB::statement("DROP POLICY IF EXISTS user_achievements_coach_insert_policy ON user_achievements");
    }
};
