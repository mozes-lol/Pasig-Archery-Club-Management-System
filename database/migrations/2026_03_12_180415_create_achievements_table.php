<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {

            $table->id('achievement_id');

            $table->string('title',150);
            $table->text('description')->nullable();
            $table->string('criteria_type',100)->nullable();
            $table->integer('criteria_value')->nullable();
            $table->string('badge_icon',255)->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at')->nullable();

            $table->foreign('created_by')
                ->references('user_id')
                ->on('users')
                ->nullOnDelete();
        });

        // Enable RLS
        DB::statement("ALTER TABLE achievements ENABLE ROW LEVEL SECURITY");

        // Anyone logged in can read achievements
        DB::statement("
        CREATE POLICY achievements_select_policy
        ON achievements
        FOR SELECT
        USING (
            current_setting('app.current_user_id', true) IS NOT NULL
        )
        ");

        // Only admins can insert/update/delete
        DB::statement("
        CREATE POLICY achievements_admin_modify
        ON achievements
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
        Schema::dropIfExists('achievements');
    }
};