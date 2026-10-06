<?php

namespace Integration\Manager\Services;

use App\Core\Jobs\SendMailJob;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use App\Manager\Services\InviteService;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CreateTest extends TestCase
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

        Queue::assertPushed(SendMailJob::class);
    }

    public function testSuccessForLegal()
    {
        $phys = $this->createPhys();
        $legal = $this->createLegal();

        Queue::assertNothingPushed();

        $result = $this->service->create($phys, $legal, InviteForWho::LEGAL);

        $this->assertInstanceOf(Invite::class, $result);
        $this->assertTrue($result->isForLegal());
        Queue::assertPushed(SendMailJob::class);
    }

    private function createPhys(): Phys
    {
        return Phys::factory()->create();
    }

    private function createLegal(): Legal
    {
        return Legal::factory()->create();
    }
}
