<?php

namespace App\Core\Http\Controllers;

use App\Core\Entities\User\Client\Client;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Notary\NotaryUser;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

abstract class AbstractController extends Controller
{
    use AuthorizesRequests;

    protected function getUserId(): int
    {
        return auth()->id();
    }

    protected function getUser(): User|Phys|Legal|Client|NotaryUser
    {
        return auth()->user();
    }
}
