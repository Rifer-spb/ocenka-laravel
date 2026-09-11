<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('legal_types')->insert([
            ['name' => 'Общество с ограниченной ответственностью', 'short_name' => 'ООО'],
            ['name' => 'Общество с дополнительной ответственностью', 'short_name' => 'ОДО'],
            ['name' => 'Индивидуальный предприниматель', 'short_name' => 'ИП'],
            ['name' => 'Акционерное общество', 'short_name' => 'АО'],
            ['name' => 'Публичное акционерное общество', 'short_name' => 'ПАО'],
            ['name' => 'Некоммерческое партнерство', 'short_name' => 'НП'],
            ['name' => 'Автономная некоммерческая организация', 'short_name' => 'АНО'],
            ['name' => 'Закрытое акционерное общество', 'short_name' => 'ЗАО'],
            ['name' => 'Открытое акционерное общество', 'short_name' => 'ОАО'],
            ['name' => 'Паевой инвестиционный фонд', 'short_name' => 'ПИФ'],
            ['name' => 'Товарищество собственников жилья', 'short_name' => 'ТСЖ'],
            ['name' => 'Учреждение', 'short_name' => 'Учреждение'],
            ['name' => 'Фонд', 'short_name' => 'Фонд'],
            ['name' => 'Общественная организация', 'short_name' => 'ОО'],
            ['name' => 'Федеральное государственное унитарное предприятие', 'short_name' => 'ФГУП'],
            ['name' => 'Государственное унитарное предприятие', 'short_name' => 'ГУП'],
            ['name' => 'Муниципальное унитарное предприятие', 'short_name' => 'МУП'],
            ['name' => 'Потребительский кооператив', 'short_name' => 'ПК'],
            ['name' => 'Государственная корпорация', 'short_name' => 'ГК'],
            ['name' => 'Ассоциация', 'short_name' => 'Ассоциация'],
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
