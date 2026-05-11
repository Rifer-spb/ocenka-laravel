<?php

namespace App\Core\Models\Invite;

enum InviteStatus: int
{
    case WAIT = 0;
    case ACTIVE = 1;
    case COMPLETE = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::WAIT => 'Ожидает подтверждения',
            self::ACTIVE => 'Активна',
            self::COMPLETE => 'Завершена',
        };
    }
}
