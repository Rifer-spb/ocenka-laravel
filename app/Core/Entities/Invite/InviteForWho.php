<?php

namespace App\Core\Entities\Invite;

enum InviteForWho: int
{
    case PHYS = 1; // Для физ.лица
    case LEGAL = 2; // Для юр.лица
}
