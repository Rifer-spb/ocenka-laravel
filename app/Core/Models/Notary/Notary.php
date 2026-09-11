<?php

namespace App\Core\Models\Notary;

use App\Core\Models\AbstractEntity;

/**
 * @property int $id
 * @property int $notariat_id id нотариуса во внешнем сервисе notariat.ru
 * @property int $region_id id региона
 * @property string $name фио нотариуса
 * @property string $address адрес нотариуса
 * @property string|null $site сайт нотариуса
 * @property bool $is_work действует ли нотариус или нет
 * @property string|null $comment произвольный комментарий
 * @property null|bool $use_digital_report принимает ли электронный отчет или нет
 * @property int $count_orders кол-во всех существующих заказов связанных с этим нотариусом
 * @property int $count_year_orders кол-во всех существующих заказов в текущем году. Каждый год сбрасывается
 * @property null|int $user_id привязанный пользователь в системе
 */
class Notary extends AbstractEntity
{
    protected $table = 'notaries';
}
