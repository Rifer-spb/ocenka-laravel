<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tableName = 'notaries';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('data_notariat_id')->unique();

            $table->unsignedInteger('region_id');
            $table->foreign('region_id')->references('id')->on('notary_regions')->onDelete('restrict');

            $table->string('name');
            $table->string('address');
            $table->string('site')->nullable();
            $table->boolean('is_work')->default(false);
            $table->string('comment')->nullable();
            $table->boolean('use_digital_report')->default(false)->nullable();
            $table->unsignedSmallInteger('count_orders')->default(0);
            $table->unsignedSmallInteger('count_year_orders')->default(0);

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
