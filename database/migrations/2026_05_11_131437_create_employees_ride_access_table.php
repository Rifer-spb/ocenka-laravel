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
        Schema::create('employee_ride_accesses', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->unsignedInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
            $table->unsignedInteger('legal_id');
            $table->foreign('legal_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedInteger('phys_id');
            $table->foreign('phys_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->boolean('value')->default(false);

            $table->unique(['employee_id', 'legal_id', 'phys_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees_ride_access');
    }
};
