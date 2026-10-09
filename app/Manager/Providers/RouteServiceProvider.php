<?php

namespace App\Manager\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::middleware(['web'])
            ->domain(config('domains.manager'))
            ->group(base_path('routes/manager/manager.php'));
    }
}
