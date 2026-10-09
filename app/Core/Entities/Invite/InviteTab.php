<?php

namespace App\Core\Entities\Invite;

enum InviteTab: string
{
    case INBOX = 'inbox';
    case OUTBOX = 'outbox';
    case ACTIVE = 'active';
    case COMPLETE = 'complete';

    /**
     * @return self[]
     */
    public static function all(): array
    {
        return self::cases();
    }

    public function isInbox(): bool
    {
        return $this === self::INBOX;
    }

    public function isOutbox(): bool
    {
        return $this === self::OUTBOX;
    }

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }

    public function isComplete(): bool
    {
        return $this === self::COMPLETE;
    }
}
