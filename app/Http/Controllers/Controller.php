<?php

namespace App\Http\Controllers;

use App\Models\User\Client\Client;
use App\Models\User\Legal\Legal;
use App\Models\User\Notary\Notary;
use App\Models\User\Phys\Phys;
use App\Models\User\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

abstract class Controller
{
    protected function tryCatch(callable $callback)
    {
        try {
            return $callback();
        } catch (\Throwable $e) {
            Log::error($e);

            if (App::environment('local', 'development')) {
                throw $e;
            } else {
                return back()->with('error', 'Произошла ошибка. Пожалуйста, попробуйте позже.');
            }
        }
    }

    protected function getUserId(): int
    {
        return auth()->id();
    }

    protected function getUser(): User|Phys|Legal|Client|Notary
    {
        return auth()->user();
    }
}
