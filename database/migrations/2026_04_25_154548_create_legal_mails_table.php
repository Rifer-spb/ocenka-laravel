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
        Schema::create('legal_mails', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->string('server')->nullable();
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            $table->unsignedTinyInteger('port')->nullable();
            $table->string('encryption')->nullable();
            $table->string('from_email')->nullable();
            $table->string('from_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_mails');
    }
};
