<?php

namespace App\Manager\Mails\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SignUpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $appName,
        public string $username,
        public string $password,
        public string $emailVerifyToken,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Регистрация на сайте',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.manager.sign-up',
            with: [
                'appName' => $this->appName,
                'username' => $this->username,
                'password' => $this->password,
                'verifyLink' => url("/manager/auth/verify-email?token={$this->emailVerifyToken}}"),
            ],
        );
    }
}
