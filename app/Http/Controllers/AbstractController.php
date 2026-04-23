<?php

namespace App\Http\Controllers;

use App\Models\User\Client\Client;
use App\Models\User\Legal\Legal;
use App\Models\User\Notary\Notary;
use App\Models\User\Phys\Phys;
use App\Models\User\User;

abstract class AbstractController
{
    protected function getUserId(): int
    {
        return auth()->id();
    }

    protected function getUser(): User|Phys|Legal|Client|Notary
    {
        return auth()->user();
    }
}
