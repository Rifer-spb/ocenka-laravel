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
        Schema::create('employees', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('legal_id');
            $table->foreign('legal_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('phys_id');
            $table->foreign('phys_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_manager')->default(false);
            $table->unsignedTinyInteger('work_rate')->nullable();

            $table->unique(['legal_id', 'phys_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
