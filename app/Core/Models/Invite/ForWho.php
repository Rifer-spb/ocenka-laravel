<?php

namespace App\Core\Models\Invite;

enum ForWho: int
{
    case PHYS = 1; // Для физ.лица
    case LEGAL = 2; // Для юр.лица
}
