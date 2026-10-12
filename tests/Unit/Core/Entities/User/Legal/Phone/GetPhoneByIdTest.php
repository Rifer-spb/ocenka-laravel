<?php

namespace Tests\Unit\Core\Entities\User\Legal\Phone;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Legal\LegalPhone;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Legal::class, 'getPhoneById')]
class GetPhoneByIdTest extends TestCase
{
    public function testInvalidId()
    {
        $legal = Legal::factory()->create();

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Номер телефона не найден.');

        $legal->getPhoneById(1);
    }

    public function testWithAnotherId()
    {
        $legal = Legal::factory()->create();
        $anotherLegal = Legal::factory()->withPhone()->create();
        $anotherLegalPhoneId = array_reverse($anotherLegal->phones->all())[0]->id;

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Номер телефона не найден.');

        $legal->getPhoneById($anotherLegalPhoneId);
    }

    public function testSuccess()
    {
        $legal = Legal::factory()->withPhone()->create();
        $phoneId = array_reverse($legal->phones->all())[0]->id;

        $phone = $legal->getPhoneById($phoneId);

        $this->assertInstanceOf(LegalPhone::class, $phone);
    }
}
