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
        Schema::create('legal_payments', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->foreign('id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('server')->nullable();
            $table->string('secret_key')->nullable();
            $table->boolean('has_qr')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_payments');
    }
};
