<?php

namespace Tests\Integration\Core\Services\Invite;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\Invite\InviteStatus;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Services\InviteService;
use App\Core\ValueObjects\Email;
use Tests\TestCase;

class CreateForPhysTest extends TestCase
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
    public function testLegalNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Юр.лицо не найдено.');

        $this->service->createForPhys(999, new Email('test@test.com'));
    }

    /**
     * @throws \Throwable
     */
    public function testPhysNotFound()
    {
        $legal = Legal::factory()->create();
        $physEmail = 'test@test.com';

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("Физ.лицо с username {$physEmail} не найдено.");

        $this->service->createForPhys($legal->id, new Email($physEmail));
    }

    public function testSuccess()
    {
        $legal = Legal::factory()->create();
        $phys = Phys::factory()->create();

        $this->service->createForPhys($legal->id, new Email($phys->email));

        $this->assertDatabaseHas(Invite::getTableName(), [
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'status' => InviteStatus::WAIT->value,
            'for' => InviteForWho::PHYS->value,
        ]);
    }
}
