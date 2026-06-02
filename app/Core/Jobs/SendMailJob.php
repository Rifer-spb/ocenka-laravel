<?php

namespace App\Core\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable;

    public int $tries = 5;

    public array $backoff = [10, 30, 60, 120];

    public function __construct(
        private Mailable $mailable
    ) {}

    public function handle(): void
    {
        Mail::send($this->mailable);
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error('SendMailJob failed: '.$exception->getMessage());
    }
}
