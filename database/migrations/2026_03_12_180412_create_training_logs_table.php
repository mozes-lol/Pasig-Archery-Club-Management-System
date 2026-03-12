<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_logs', function (Blueprint $table) {

            $table->id('log_id');

            $table->unsignedBigInteger('archer_id');
            $table->unsignedBigInteger('coach_id');

            $table->date('session_date');

            $table->integer('distance')->nullable();
            $table->integer('arrow_count')->nullable();
            $table->integer('total_score')->nullable();
            $table->integer('coach_rating')->nullable();

            $table->text('technical_notes')->nullable();
            $table->dateTime('created_at')->nullable();

            $table->foreign('archer_id')
                ->references('archer_id')
                ->on('archers')
                ->onDelete('cascade');

            $table->foreign('coach_id')
                ->references('coach_id')
                ->on('coaches')
                ->onDelete('cascade');
        });

        // Enable Row Level Security
        DB::statement("ALTER TABLE training_logs ENABLE ROW LEVEL SECURITY");

        /*
        Archer: can see logs that belong to them
        */
        DB::statement("
        CREATE POLICY training_logs_archer_policy
        ON training_logs
        FOR SELECT
        USING (
            archer_id IN (
                SELECT archer_id
                FROM archers
                WHERE user_id = current_setting('app.current_user_id')::int
            )
        )
        ");

        /*
        Coach: can see logs where they are the coach
        */
        DB::statement("
        CREATE POLICY training_logs_coach_policy
        ON training_logs
        FOR SELECT
        USING (
            coach_id IN (
                SELECT coach_id
                FROM coaches
                WHERE user_id = current_setting('app.current_user_id')::int
            )
        )
        ");

        /*
        Admin: full control
        */
        DB::statement("
        CREATE POLICY training_logs_admin_policy
        ON training_logs
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
        Schema::dropIfExists('training_logs');
    }
};