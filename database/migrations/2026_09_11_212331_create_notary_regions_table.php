<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'notary_regions';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('notariat_region_id')->unique();
            $table->string('name');
            $table->string('group_name');
            $table->unsignedSmallInteger('code')->unique();
        });

        foreach ($this->getRegions() as $region) {
            DB::table($this->tableName)->insert([
                'notariat_region_id' => $region['notariat_region_id'],
                'name' => $region['name'],
                'group_name' => $region['group_name'],
                'code' => $region['code'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }

    private function getRegions(): array
    {
        return array(
            array('id' => '1','notariat_region_id' => '11','group_name' => 'Нотариальная палата Астраханской области','name' => 'Астраханская область','code' => '30'),
            array('id' => '2','notariat_region_id' => '43','group_name' => 'Нотариальная палата Амурской области','name' => 'Амурская область','code' => '28'),
            array('id' => '3','notariat_region_id' => '54','group_name' => 'Нотариальная палата Архангельской области','name' => 'Архангельская область','code' => '29'),
            array('id' => '4','notariat_region_id' => '55','group_name' => 'Нотариальная палата Республики Адыгея','name' => 'Республика Адыгея (Адыгея)','code' => '1'),
            array('id' => '5','notariat_region_id' => '60','group_name' => 'Алтайская краевая нотариальная палата','name' => 'Алтайский край','code' => '22'),
            array('id' => '6','notariat_region_id' => '69','group_name' => 'Нотариальная палата Республики Алтай','name' => 'Республика Алтай','code' => '4'),
            array('id' => '7','notariat_region_id' => '21','group_name' => 'Некоммерческая организация «Нотариальная палата Республики Башкортостан»','name' => 'Республика Башкортостан','code' => '2'),
            array('id' => '8','notariat_region_id' => '22','group_name' => 'Нотариальная палата Республики Бурятия','name' => 'Республика Бурятия','code' => '3'),
            array('id' => '9','notariat_region_id' => '57','group_name' => 'Брянская областная нотариальная палата','name' => 'Брянская область','code' => '32'),
            array('id' => '10','notariat_region_id' => '58','group_name' => 'Белгородская областная нотариальная палата','name' => 'Белгородская область','code' => '31'),
            array('id' => '11','notariat_region_id' => '27','group_name' => 'Нотариальная палата Воронежской области','name' => 'Воронежская область','code' => '36'),
            array('id' => '12','notariat_region_id' => '33','group_name' => 'Нотариальная палата Волгоградской области','name' => 'Волгоградская область','code' => '34'),
            array('id' => '13','notariat_region_id' => '44','group_name' => 'Нотариальная палата Вологодской области','name' => 'Вологодская область','code' => '35'),
            array('id' => '14','notariat_region_id' => '53','group_name' => 'Владимирская областная нотариальная палата','name' => 'Владимирская область','code' => '33'),
            array('id' => '15','notariat_region_id' => '28','group_name' => 'Нотариальная палата Республики Дагестан','name' => 'Республика Дагестан','code' => '5'),
            array('id' => '16','notariat_region_id' => '94','group_name' => 'Нотариальная палата Донецкой Народной Республики','name' => 'Донецкая Народная Республика','code' => '93'),
            array('id' => '17','notariat_region_id' => '63','group_name' => 'Нотариальная палата Еврейской автономной области','name' => 'Еврейская автономная область','code' => '79'),
            array('id' => '18','notariat_region_id' => '67','group_name' => 'Нотариальная палата Забайкальского края','name' => 'Забайкальский край','code' => '75'),
            array('id' => '19','notariat_region_id' => '92','group_name' => 'Нотариальная палата Запорожской области','name' => 'Запорожская область','code' => '90'),
            array('id' => '20','notariat_region_id' => '14','group_name' => 'Нотариальная палата Республики Ингушетия','name' => 'Республика Ингушетия','code' => '6'),
            array('id' => '21','notariat_region_id' => '36','group_name' => 'Нотариальная палата Иркутской области','name' => 'Иркутская область','code' => '38'),
            array('id' => '22','notariat_region_id' => '84','group_name' => 'Ивановская областная нотариальная палата','name' => 'Ивановская область','code' => '37'),
            array('id' => '23','notariat_region_id' => '5','group_name' => 'Нотариальная палата Камчатского края','name' => 'Камчатский край','code' => '41'),
            array('id' => '24','notariat_region_id' => '7','group_name' => 'Костромская областная нотариальная палата','name' => 'Костромская область','code' => '44'),
            array('id' => '25','notariat_region_id' => '29','group_name' => 'Нотариальная палата Красноярского края','name' => 'Красноярский край','code' => '24'),
            array('id' => '26','notariat_region_id' => '31','group_name' => 'Нотариальная палата Республики Карелия','name' => 'Республика Карелия','code' => '10'),
            array('id' => '27','notariat_region_id' => '34','group_name' => 'Нотариальная палата Калининградской области','name' => 'Калининградская область','code' => '39'),
            array('id' => '28','notariat_region_id' => '37','group_name' => 'Курская областная нотариальная палата','name' => 'Курская область','code' => '46'),
            array('id' => '29','notariat_region_id' => '39','group_name' => 'Кемеровская областная нотариальная палата','name' => 'Кемеровская область — Кузбасс','code' => '42'),
            array('id' => '30','notariat_region_id' => '40','group_name' => 'Нотариальная палата Республики Коми','name' => 'Республика Коми','code' => '11'),
            array('id' => '31','notariat_region_id' => '41','group_name' => 'Калужская областная нотариальная палата','name' => 'Калужская область','code' => '40'),
            array('id' => '32','notariat_region_id' => '52','group_name' => 'Кировская областная нотариальная палата','name' => 'Кировская область','code' => '43'),
            array('id' => '33','notariat_region_id' => '59','group_name' => 'Нотариальная палата Карачаево-Черкесской Республики','name' => 'Карачаево-Черкесская Республика','code' => '9'),
            array('id' => '34','notariat_region_id' => '66','group_name' => 'Нотариальная палата Краснодарского края','name' => 'Краснодарский край','code' => '23'),
            array('id' => '35','notariat_region_id' => '68','group_name' => 'Нотариальная палата Кабардино-Балкарской Республики','name' => 'Кабардино-Балкарская Республика','code' => '7'),
            array('id' => '36','notariat_region_id' => '75','group_name' => 'Нотариальная палата Республики Калмыкия','name' => 'Республика Калмыкия','code' => '8'),
            array('id' => '37','notariat_region_id' => '81','group_name' => 'Нотариальная палата Курганской области','name' => 'Курганская область','code' => '45'),
            array('id' => '38','notariat_region_id' => '86','group_name' => 'Нотариальная палата Республики Крым','name' => 'Республика Крым','code' => '91'),
            array('id' => '39','notariat_region_id' => '15','group_name' => 'Нотариальная палата Ленинградской области','name' => 'Ленинградская область','code' => '47'),
            array('id' => '40','notariat_region_id' => '74','group_name' => 'Липецкая областная нотариальная палата','name' => 'Липецкая область','code' => '48'),
            array('id' => '41','notariat_region_id' => '93','group_name' => 'Нотариальная палата Луганской Народной Республики','name' => 'Луганская Народная Республика','code' => '94'),
            array('id' => '42','notariat_region_id' => '2','group_name' => 'Нотариальная палата Республики Марий Эл','name' => 'Республика Марий Эл','code' => '12'),
            array('id' => '43','notariat_region_id' => '9','group_name' => 'Мурманская областная нотариальная палата','name' => 'Мурманская область','code' => '51'),
            array('id' => '44','notariat_region_id' => '19','group_name' => 'Московская областная Нотариальная Палата','name' => 'Московская область','code' => '50'),
            array('id' => '45','notariat_region_id' => '50','group_name' => 'Магаданская областная нотариальная палата','name' => 'Магаданская область','code' => '49'),
            array('id' => '46','notariat_region_id' => '61','group_name' => 'Нотариальная палата Республики Мордовия','name' => 'Республика Мордовия','code' => '13'),
            array('id' => '47','notariat_region_id' => '79','group_name' => 'Московская городская нотариальная палата','name' => 'г Москва','code' => '77'),
            array('id' => '48','notariat_region_id' => '8','group_name' => 'Нотариальная палата Новосибирской области','name' => 'Новосибирская область','code' => '54'),
            array('id' => '49','notariat_region_id' => '10','group_name' => 'Новгородская областная нотариальная палата','name' => 'Новгородская область','code' => '53'),
            array('id' => '50','notariat_region_id' => '23','group_name' => 'Нижегородская областная нотариальная палата','name' => 'Нижегородская область','code' => '52'),
            array('id' => '51','notariat_region_id' => '47','group_name' => 'Орловская областная нотариальная палата','name' => 'Орловская область','code' => '57'),
            array('id' => '52','notariat_region_id' => '71','group_name' => 'Нотариальная палата Оренбургской области','name' => 'Оренбургская область','code' => '56'),
            array('id' => '53','notariat_region_id' => '82','group_name' => 'Нотариальная палата Омской области','name' => 'Омская область','code' => '55'),
            array('id' => '54','notariat_region_id' => '24','group_name' => 'Приморская краевая нотариальная палата','name' => 'Приморский край','code' => '25'),
            array('id' => '55','notariat_region_id' => '35','group_name' => 'Нотариальная палата Пермского края','name' => 'Пермский край','code' => '59'),
            array('id' => '56','notariat_region_id' => '38','group_name' => 'Нотариальная палата Псковской области','name' => 'Псковская область','code' => '60'),
            array('id' => '57','notariat_region_id' => '49','group_name' => 'Нотариальная палата Пензенской области','name' => 'Пензенская область','code' => '58'),
            array('id' => '58','notariat_region_id' => '13','group_name' => 'Нотариальная палата Ростовской области','name' => 'Ростовская область','code' => '61'),
            array('id' => '59','notariat_region_id' => '77','group_name' => 'Рязанская областная нотариальная палата','name' => 'Рязанская область','code' => '62'),
            array('id' => '60','notariat_region_id' => '3','group_name' => 'Сахалинская областная нотариальная палата','name' => 'Сахалинская область','code' => '65'),
            array('id' => '61','notariat_region_id' => '18','group_name' => 'Смоленская областная нотариальная палата','name' => 'Смоленская область','code' => '67'),
            array('id' => '62','notariat_region_id' => '30','group_name' => 'Саратовская областная нотариальная палата','name' => 'Саратовская область','code' => '64'),
            array('id' => '63','notariat_region_id' => '45','group_name' => 'Нотариальная палата Санкт-Петербурга','name' => 'г Санкт-Петербург','code' => '78'),
            array('id' => '64','notariat_region_id' => '62','group_name' => 'Нотариальная палата Ставропольского края','name' => 'Ставропольский край','code' => '26'),
            array('id' => '65','notariat_region_id' => '64','group_name' => 'Нотариальная Палата Самарской области','name' => 'Самарская область','code' => '63'),
            array('id' => '66','notariat_region_id' => '73','group_name' => 'Нотариальная палата Республики Саха (Якутия)','name' => 'Республика Саха (Якутия)','code' => '14'),
            array('id' => '67','notariat_region_id' => '76','group_name' => 'Нотариальная палата Республики Северная Осетия - Алания','name' => 'Республика Северная Осетия — Алания','code' => '15'),
            array('id' => '68','notariat_region_id' => '83','group_name' => 'Нотариальная палата Свердловской области','name' => 'Свердловская область','code' => '66'),
            array('id' => '69','notariat_region_id' => '85','group_name' => 'Нотариальная палата города Севастополя','name' => 'г Севастополь','code' => '92'),
            array('id' => '70','notariat_region_id' => '32','group_name' => 'Нотариальная палата Республики Тыва','name' => 'Республика Тыва','code' => '17'),
            array('id' => '71','notariat_region_id' => '42','group_name' => 'Тюменская областная нотариальная палата','name' => 'Тюменская область','code' => '72'),
            array('id' => '72','notariat_region_id' => '46','group_name' => 'Нотариальная палата Республики Татарстан','name' => 'Республика Татарстан (Татарстан)','code' => '16'),
            array('id' => '73','notariat_region_id' => '51','group_name' => 'Тамбовская областная нотариальная палата','name' => 'Тамбовская область','code' => '68'),
            array('id' => '74','notariat_region_id' => '70','group_name' => 'Нотариальная палата Тверской области','name' => 'Тверская область','code' => '69'),
            array('id' => '75','notariat_region_id' => '72','group_name' => 'Тульская областная нотариальная палата','name' => 'Тульская область','code' => '71'),
            array('id' => '76','notariat_region_id' => '78','group_name' => 'Томская областная нотариальная палата','name' => 'Томская область','code' => '70'),
            array('id' => '77','notariat_region_id' => '17','group_name' => 'Нотариальная палата Удмуртской Республики','name' => 'Удмуртская Республика','code' => '18'),
            array('id' => '78','notariat_region_id' => '80','group_name' => 'Нотариальная Палата Ульяновской области','name' => 'Ульяновская область','code' => '73'),
            array('id' => '79','notariat_region_id' => '1','group_name' => 'Нотариальная палата Республики Хакасия','name' => 'Республика Хакасия','code' => '19'),
            array('id' => '80','notariat_region_id' => '6','group_name' => 'Нотариальная палата Хабаровского края','name' => 'Хабаровский край','code' => '27'),
            array('id' => '81','notariat_region_id' => '20','group_name' => 'Нотариальная палата Ханты-Мансийского автономного округа-Югры','name' => 'Ханты-Мансийский автономный округ — Югра','code' => '86'),
            array('id' => '82','notariat_region_id' => '91','group_name' => 'Нотариальная палата Херсонской области','name' => 'Херсонская область','code' => '95'),
            array('id' => '83','notariat_region_id' => '25','group_name' => 'Челябинская областная нотариальная палата','name' => 'Челябинская область','code' => '74'),
            array('id' => '84','notariat_region_id' => '26','group_name' => 'Нотариальная палата Чеченской Республики','name' => 'Чеченская Республика','code' => '20'),
            array('id' => '85','notariat_region_id' => '48','group_name' => 'Нотариальная палата Чувашской Республики','name' => 'Чувашская Республика — Чувашия','code' => '21'),
            array('id' => '86','notariat_region_id' => '56','group_name' => 'Чукотская окружная нотариальная палата','name' => 'Чукотский автономный округ','code' => '87'),
            array('id' => '87','notariat_region_id' => '4','group_name' => 'Ярославская областная нотариальная палата','name' => 'Ярославская область','code' => '76'),
            array('id' => '88','notariat_region_id' => '65','group_name' => 'Нотариальная палата Ямало-Ненецкого автономного округа','name' => 'Ямало-Ненецкий автономный округ','code' => '89')
        );
    }
};
