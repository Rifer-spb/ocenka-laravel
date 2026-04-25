<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('phys_profiles', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table
                ->foreign('id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('telegram_id', 20)->nullable()->unique();
            $table->boolean('is_admin')->default(false);
            $table->date('holiday_from')->nullable();
            $table->date('holiday_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phys_profiles');
    }
};
