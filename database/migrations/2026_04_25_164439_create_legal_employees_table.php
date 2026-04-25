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
        Schema::create('legal_employees', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->unsignedInteger('legal_id');
            $table->foreign('legal_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('phys_id');
            $table->foreign('phys_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedTinyInteger('for');
            $table->unsignedTinyInteger('status')->default(0);
            $table->boolean('is_manager')->default(false);
            $table->unsignedTinyInteger('work_rate')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('fired_at')->nullable();

            $table->unique(['legal_id', 'phys_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_employees');
    }
};
