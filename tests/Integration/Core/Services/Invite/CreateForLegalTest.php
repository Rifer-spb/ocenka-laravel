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

class CreateForLegalTest extends TestCase
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
    public function testPhysNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Физ.лицо не найдено.');

        $this->service->createForLegal(999, new Email('test@test.com'));
    }

    /**
     * @throws \Throwable
     */
    public function testLegalNotFound()
    {
        $phys = Phys::factory()->create();
        $legalEmail = 'test@test.com';

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("Юр.лицо с username {$legalEmail} не найдено.");

        $this->service->createForLegal($phys->id, new Email($legalEmail));
    }

    public function testSuccess()
    {
        $phys = Phys::factory()->create();
        $legal = Legal::factory()->create();

        $this->service->createForLegal($phys->id, new Email($legal->email));

        $this->assertDatabaseHas(Invite::getTableName(), [
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'status' => InviteStatus::WAIT->value,
            'for' => InviteForWho::LEGAL->value,
        ]);
    }
}
