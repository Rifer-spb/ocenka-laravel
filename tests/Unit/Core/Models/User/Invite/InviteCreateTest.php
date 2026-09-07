<?php

namespace Tests\Unit\Core\Models\User\Invite;

use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
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

        $invite = Invite::createNew($phys, $legal, InviteForWho::LEGAL);
        $invite->confirm();
        $invite->saveOrFail();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Связь с указанным уже установлена.');

        Invite::createNew($phys, $legal, InviteForWho::LEGAL);
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
