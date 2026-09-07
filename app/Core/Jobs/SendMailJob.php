<?php

namespace App\Core\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public array $backoff = [10, 30, 60, 120];

    private Mailable $mailable;

    public function __construct(
        Mailable $mailable
    ) {
        $this->mailable = $mailable;
    }

    public function handle(): void
    {
        Mail::send($this->mailable);
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error('SendMailJob failed: '.$exception->getMessage());
    }
}
