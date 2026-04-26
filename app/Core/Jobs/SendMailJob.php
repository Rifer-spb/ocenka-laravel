<?php

namespace App\Core\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable;

    public function __construct(
        private string $view,
        private array $data,
        private string $emailTo,
        private string $subject,
    ) {}

    public function handle(): void
    {
        Mail::send($this->view, $this->data, function ($message) {
            $message
                ->to($this->emailTo)
                ->subject($this->subject);
        });
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error('Job failed: '.$exception->getMessage());
    }
}
