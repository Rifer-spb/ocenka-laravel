<?php

namespace Tests\Integration\Core\Services\Invite;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\Invite\Invite;
use App\Core\Services\InviteService;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(InviteService::class, 'confirm')]
class ConfirmTest extends TestCase
{
    private InviteService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(InviteService::class);
    }

    /**
     * @throws \Throwable
     */
    public function testNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Приглашение не найдено.');

        $this->service->confirm(999);
    }

    /**
     * @throws \Throwable
     */
    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withActive()->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Заявка должна быть в статусе ожидания.');

        $this->service->confirm($invite->id);
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $invite = Invite::factory()->withWait()->create();
        $this->service->confirm($invite->id);
        $invite->refresh();

        $this->assertTrue($invite->isActive());
    }
}
