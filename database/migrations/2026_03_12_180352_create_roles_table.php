<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('role_name', 50)->unique();
        });

        // Enable RLS
        DB::statement("ALTER TABLE roles ENABLE ROW LEVEL SECURITY");

        // Allow all authenticated users to read roles
        DB::statement("
        CREATE POLICY roles_select_policy
        ON roles
        FOR SELECT
        USING (
            current_setting('app.current_user_id', true) IS NOT NULL
        )
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};