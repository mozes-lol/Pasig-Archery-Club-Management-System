<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('coaches', function (Blueprint $table) {

            $table->id('coach_id');

            $table->unsignedBigInteger('user_id')->unique();

            $table->string('certification',150)->nullable();
            $table->string('specialization',150)->nullable();
            $table->date('hire_date')->nullable();

            $table->foreign('user_id')->references('user_id')->on('users');

        });

        DB::statement("ALTER TABLE coaches ENABLE ROW LEVEL SECURITY");

        DB::statement("
        CREATE POLICY coach_self_policy
        ON coaches
        USING (
            user_id = current_setting('app.current_user_id')::int
        )
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('coaches');
    }
};