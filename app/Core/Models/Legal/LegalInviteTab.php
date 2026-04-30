<?php

namespace App\Core\Models\Legal;

readonly class LegalInviteTab
{
    private const TAB_INBOX = 'inbox';
    private const TAB_OUTBOX = 'outbox';
    private const TAB_ACTIVE= 'active';
    private const TAB_COMPLETE = 'complete';

    private const TABS = [
        ['id' => self::TAB_INBOX, 'name' => 'Входящие'],
        ['id' => self::TAB_OUTBOX, 'name' => 'Исходящие'],
        ['id' => self::TAB_ACTIVE, 'name' => 'Активные'],
        ['id' => self::TAB_COMPLETE, 'name' => 'Завершенные'],
    ];

    private const STATUSES = [
        self::TAB_INBOX => LegalInviteStatus::WAIT->value,
        self::TAB_OUTBOX => LegalInviteStatus::WAIT->value,
        self::TAB_ACTIVE => LegalInviteStatus::ACTIVE->value,
        self::TAB_COMPLETE => LegalInviteStatus::COMPLETE->value,
    ];

    private function __construct(
        public string $id,
        public string $name,
    ) {}

    /**
     * @return self[]
     */
    public static function all(): array
    {
        return array_map(fn(array $tab) => new self($tab['id'], $tab['name']), self::TABS);
    }

    public function isInbox(): bool
    {
        return $this->id === self::TAB_INBOX;
    }

    public function isOutbox(): bool
    {
        return $this->id === self::TAB_OUTBOX;
    }

    public function isActive(): bool
    {
        return $this->id === self::TAB_ACTIVE;
    }

    public function isComplete(): bool
    {
        return $this->id === self::TAB_COMPLETE;
    }

    public function getStatus(): string
    {
        return self::STATUSES[$this->id];
    }
}
