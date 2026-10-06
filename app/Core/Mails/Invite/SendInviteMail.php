<?php

namespace App\Core\Mails\Invite;

use App\Core\Entities\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class SendInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    private function __construct(
        public string $emailTo,
        public string $viewLink
    ) {}

    public static function create(User $user): self
    {
        if ($user->isPhys()) {
            $viewLink = url("/manager/{$user->role}/settings/invites");
        } elseif ($user->isLegal()) {
            $viewLink = url("/manager/{$user->role}/settings/invites");
        } else {
            throw new \Exception('Недопустимая роль пользователя.');
        }

        return new self($user->email, $viewLink);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->emailTo,
            subject: 'Приглашение с сайта',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.manager.invite.new-invite',
            with: [
                'appName' => Config::get('app.name'),
                'link' => $this->viewLink,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
