<?php

namespace Tests\Unit\Core\Models\User\Invite;

use App\Core\Models\Invite\ForWho;
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

        $invite = Invite::createNew($phys, $legal, ForWho::PHYS);
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

        $invite = Invite::createNew($phys, $legal, ForWho::LEGAL);
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

        Invite::createNew($phys, $legal, ForWho::PHYS);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Заявка с указанным уже существует.');

        Invite::createNew($phys, $legal, ForWho::PHYS);
    }

    public function testAlreadyExistActive()
    {
        $phys = $this->createPhys();
        $legal = $this->createLegal();

        $invite = Invite::createNew($phys, $legal, ForWho::LEGAL);
        $invite->confirm();
        $invite->saveOrFail();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Связь с указанным уже установлена.');

        Invite::createNew($phys, $legal, ForWho::LEGAL);
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
