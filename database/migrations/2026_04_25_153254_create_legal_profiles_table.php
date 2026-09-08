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
        Schema::create('legal_profiles', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table
                ->foreign('id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedInteger('type_id')->nullable();
            $table
                ->foreign('type_id')
                ->references('id')
                ->on('legal_types')
                ->onDelete('restrict');
            $table->string('full_name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('abbr', 100)->nullable();
            $table->string('address')->nullable();
            $table->date('date_ogrn')->nullable();
            $table->unsignedBigInteger('inn')->nullable();
            $table->unsignedBigInteger('kpp')->nullable();
            $table->unsignedBigInteger('ogrn')->nullable();
            $table->boolean('registry_h1')->default(false);
            $table->string('registry_template', 100)->default('ССС-ГГ');
            $table->string('token_mango')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_profiles');
    }
};
