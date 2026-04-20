<?php

namespace App\Jobs\Manager\Auth;

use App\Models\User\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSignUpEmailJob implements ShouldQueue
{
    use Dispatchable;

    public function __construct(
        private User $user
    ) {}

    public function handle(): void
    {

    }

    public function failed(\Throwable $exception): void
    {
        logger()->error('Job failed: ' . $exception->getMessage());
    }
}
