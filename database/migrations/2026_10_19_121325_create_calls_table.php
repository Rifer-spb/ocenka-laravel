<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'calls';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('legal_id');
            $table->foreign('legal_id')->references('id')->on('users');
            $table->unsignedInteger('phys_id')->nullable();
            $table->foreign('phys_id')->references('id')->on('users');
            $table->string('mango_call_id', 100)->unique();
            $table->string('phone_from', 50);
            $table->string('phone_to', 50);
            $table->unsignedSmallInteger('status');
            $table->text('comment')->nullable();
            $table->timestamp('appeared_at');
            $table->timestamp('connected_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->string('talk_time',10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
