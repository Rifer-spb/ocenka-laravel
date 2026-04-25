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
        Schema::create('legal_employee_report_access', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->unsignedInteger('legal_employee_id');
            $table->foreign('legal_employee_id')
                ->references('id')
                ->on('legal_employees')
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
            $table->unsignedInteger('direction_id');
            $table->foreign('direction_id')
                ->references('id')
                ->on('directions')
                ->onDelete('cascade');
            $table->boolean('do')->default(false);
            $table->boolean('write')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_employee_report_access');
    }
};
