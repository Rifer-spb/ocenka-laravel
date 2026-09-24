<?php

namespace App\Core\Http\Controllers;

use App\Core\Models\User\Client\Client;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Notary\NotaryUser;
use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\User;

abstract class AbstractController
{
    protected function getUserId(): int
    {
        return auth()->id();
    }

    protected function getUser(): User|Phys|Legal|Client|NotaryUser
    {
        return auth()->user();
    }
}
