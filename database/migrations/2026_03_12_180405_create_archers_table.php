<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('archers', function (Blueprint $table) {

            $table->id('archer_id');

            $table->unsignedBigInteger('user_id')->unique();

            $table->string('experience_level',50)->nullable();
            $table->string('ranking',50)->nullable();
            $table->date('join_date')->nullable();

            $table->foreign('user_id')->references('user_id')->on('users');

        });

        DB::statement("ALTER TABLE archers ENABLE ROW LEVEL SECURITY");

        DB::statement("
        CREATE POLICY archer_self_policy
        ON archers
        USING (
            user_id = current_setting('app.current_user_id')::int
        )
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('archers');
    }
};