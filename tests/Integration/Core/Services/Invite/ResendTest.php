<?php

namespace Tests\Integration\Core\Services\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Jobs\SendMailJob;
use App\Core\Services\InviteService;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(InviteService::class, 'reSendEmail')]
class ResendTest extends TestCase
{
    private InviteService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(InviteService::class);
    }

    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withActive()->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Заявка не в статуса ожидания.');

        $this->service->reSendEmail($invite->id);
    }

    public function testSuccess()
    {
        Queue::assertNothingPushed();

        $invite = Invite::factory()->withWait()->create();
        $this->service->reSendEmail($invite->id);

        Queue::assertPushed(SendMailJob::class);
    }
}
