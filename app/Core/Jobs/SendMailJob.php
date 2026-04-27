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
        private Mailable $mailable,
        private string $emailTo,
    ) {}

    public function handle(): void
    {
        Mail::to($this->emailTo)->send($this->mailable);
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error('Job failed: '.$exception->getMessage());
    }
}
