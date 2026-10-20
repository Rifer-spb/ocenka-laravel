<?php

namespace App\Core\Events\WebSocket;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class UserEvent implements ShouldBroadcastNow
{
    public function __construct(
        public EventType $type,
        public int|array $userId,
        public array $data
    ) {}

    public function broadcastOn(): array
    {
        $userIds = is_array($this->userId)
            ? $this->userId
            : [$this->userId];

        $callback = fn (int $id) => new PrivateChannel("user.{$id}");

        return array_map($callback, $userIds);
    }

    public function broadcastAs(): string
    {
        return 'UserEvent';
    }

    public function broadcastWith(): array
    {
        return ['type' => $this->type->value, 'data' => $this->data];
    }
}
