<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'employees';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->string('phone_extension',5)->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn('phone_extension');
        });
    }
};
