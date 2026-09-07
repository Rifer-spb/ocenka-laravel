<?php

namespace Integration\Manager\Services;

use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use App\Manager\Jobs\Invite\SendInviteMailJob;
use App\Manager\Services\InviteService;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class InviteCreateTest extends TestCase
{
    private InviteService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(InviteService::class);
    }

    public function testSuccessForPhys()
    {
        $phys = $this->createPhys();
        $legal = $this->createLegal();

        Queue::assertNothingPushed();

        $result = $this->service->create($phys, $legal, InviteForWho::PHYS);

        $this->assertInstanceOf(Invite::class, $result);
        $this->assertTrue($result->isForPhys());
        Queue::assertPushed(SendInviteMailJob::class);
    }

    public function testSuccessForLegal()
    {
        $phys = $this->createPhys();
        $legal = $this->createLegal();

        Queue::assertNothingPushed();

        $result = $this->service->create($phys, $legal, InviteForWho::LEGAL);

        $this->assertInstanceOf(Invite::class, $result);
        $this->assertTrue($result->isForLegal());
        Queue::assertPushed(SendInviteMailJob::class);
    }

    private function createPhys(): Phys
    {
        return Phys::createNew(
            new Email('phys@test.com'),
            new Password('password')
        );
    }

    private function createLegal(): Legal
    {
        return Legal::createNew(
            new Email('legal@test.com'),
            new Password('password')
        );
    }
}
