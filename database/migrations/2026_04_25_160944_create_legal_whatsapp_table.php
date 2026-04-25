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
        Schema::create('legal_whatsapp', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->string('api_url')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_id')->nullable();
            $table->string('phone', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_whatsapp');
    }
};
