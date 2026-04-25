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
        DB::table('directions')->insert([
            ['name' => 'Оценка бизнеса', 'short_name' => 'ОБ'],
            ['name' => 'Оценка недвижимости', 'short_name' => 'ОН'],
            ['name' => 'Оценка машин и оборудования', 'short_name' => 'ОМиО'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
