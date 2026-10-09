<?php

namespace Tests\Unit\Core\Entities\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use Tests\TestCase;

class InviteCreateTest extends TestCase
{
    public function testSuccessForPhys()
    {
        $phys = $this->createPhys();
        $legal = $this->createLegal();

        $invite = Invite::createNew($phys, $legal, InviteForWho::PHYS);
        $invite = Invite::findOrFail($invite->id);

        $this->assertEquals($invite->phys_id, $phys->id);
        $this->assertEquals($invite->legal_id, $legal->id);
        $this->assertTrue($invite->isForPhys());
        $this->assertTrue($invite->isWait());
    }

    public function testSuccessForLegal()
    {
        $phys = $this->createPhys();
        $legal = $this->createLegal();

        $invite = Invite::createNew($phys, $legal, InviteForWho::LEGAL);
        $invite = Invite::findOrFail($invite->id);

        $this->assertEquals($invite->phys_id, $phys->id);
        $this->assertEquals($invite->legal_id, $legal->id);
        $this->assertTrue($invite->isForLegal());
        $this->assertTrue($invite->isWait());
    }

    public function testAlreadyExistWait()
    {
        $phys = $this->createPhys();
        $legal = $this->createLegal();

        Invite::createNew($phys, $legal, InviteForWho::PHYS);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Заявка с указанным уже существует.');

        Invite::createNew($phys, $legal, InviteForWho::PHYS);
    }

    public function testAlreadyExistActive()
    {
        $phys = $this->createPhys();
        $legal = $this->createLegal();

        Invite::factory()
            ->state([
                'phys_id' => $phys->id,
                'legal_id' => $legal->id,
            ])
            ->withActive()
            ->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Связь с указанным уже установлена.');

        Invite::createNew($phys, $legal, InviteForWho::LEGAL);
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
