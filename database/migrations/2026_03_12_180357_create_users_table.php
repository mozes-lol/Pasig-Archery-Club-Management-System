<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id('user_id');

            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('email',150)->unique();
            $table->string('password_hash',255);

            $table->unsignedBigInteger('role_id');
            $table->string('status',20);

            $table->dateTime('registered_at')->nullable();

            $table->unsignedBigInteger('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();

            $table->foreign('role_id')
                ->references('role_id')
                ->on('roles');

            $table->foreign('approved_by')
                ->references('user_id')
                ->on('users')
                ->nullOnDelete();
        });

        // Enable RLS
        DB::statement("ALTER TABLE users ENABLE ROW LEVEL SECURITY");

        /*
        Users can see their own row
        */
        DB::statement("
        CREATE POLICY users_self_policy
        ON users
        FOR SELECT
        USING (
            user_id = current_setting('app.current_user_id')::int
        )
        ");

        /*
        Admin full access
        */
        DB::statement("
        CREATE POLICY users_admin_policy
        ON users
        FOR ALL
        USING (
            EXISTS (
                SELECT 1
                FROM users u
                WHERE u.user_id = current_setting('app.current_user_id')::int
                AND u.role_id = 1
            )
        )
        WITH CHECK (
            EXISTS (
                SELECT 1
                FROM users u
                WHERE u.user_id = current_setting('app.current_user_id')::int
                AND u.role_id = 1
            )
        )
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};