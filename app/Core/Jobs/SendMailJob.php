<?php

namespace App\Core\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable;

    public function __construct(
        private Mailable $mailable
    ) {}

    public function handle(): void
    {
        Mail::send($this->mailable);
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error('Job failed: '.$exception->getMessage());
    }
}
