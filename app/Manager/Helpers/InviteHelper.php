<?php

namespace App\Manager\Helpers;

use App\Core\Entities\Invite\InviteStatus;
use App\Core\Entities\Invite\InviteTab;

class InviteHelper
{
    public static function getTabs(): array
    {
        return array_map(fn(InviteTab $t) => ['id' => $t->value, 'name' => self::getTabName($t)], InviteTab::all());
    }

    public static function getStatusByTab(InviteTab $tab): InviteStatus
    {
        return match($tab) {
            InviteTab::INBOX, InviteTab::OUTBOX => InviteStatus::WAIT,
            InviteTab::ACTIVE => InviteStatus::ACTIVE,
            InviteTab::COMPLETE => InviteStatus::COMPLETE,
        };
    }

    public static function getTabName(InviteTab $tab): string
    {
        return match($tab) {
            InviteTab::INBOX => 'Входящие',
            InviteTab::OUTBOX => 'Исходящие',
            InviteTab::ACTIVE => 'Активные',
            InviteTab::COMPLETE => 'Завершенные',
        };
    }
}
