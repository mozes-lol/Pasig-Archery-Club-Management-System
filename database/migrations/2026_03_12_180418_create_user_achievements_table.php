<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_achievements', function (Blueprint $table) {

            $table->id('user_achievement_id');

            $table->unsignedBigInteger('archer_id');
            $table->unsignedBigInteger('achievement_id');

            $table->date('date_awarded')->nullable();

            $table->foreign('archer_id')
                ->references('archer_id')
                ->on('archers')
                ->onDelete('cascade');

            $table->foreign('achievement_id')
                ->references('achievement_id')
                ->on('achievements')
                ->onDelete('cascade');
        });

        // Enable RLS
        DB::statement("ALTER TABLE user_achievements ENABLE ROW LEVEL SECURITY");

        // Archer can view their own achievements
        DB::statement("
        CREATE POLICY user_achievements_self_policy
        ON user_achievements
        FOR SELECT
        USING (
            archer_id IN (
                SELECT archer_id
                FROM archers
                WHERE user_id = current_setting('app.current_user_id')::int
            )
        )
        ");

        // Admin full access
        DB::statement("
        CREATE POLICY user_achievements_admin_policy
        ON user_achievements
        FOR ALL
        USING (
            EXISTS (
                SELECT 1 FROM users
                WHERE users.user_id = current_setting('app.current_user_id')::int
                AND users.role_id = 1
            )
        )
        WITH CHECK (
            EXISTS (
                SELECT 1 FROM users
                WHERE users.user_id = current_setting('app.current_user_id')::int
                AND users.role_id = 1
            )
        )
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('user_achievements');
    }
};