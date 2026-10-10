<?php

namespace Tests\Unit\Core\Entities\User\Phys\Phone;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\Phys\PhysPhone;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Phys::class, 'getPhoneByValue')]
class GetPhoneByValueTest extends TestCase
{
    public function testFalse()
    {
        $phys = Phys::factory()->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Телефон не найден.');

        $phys->getPhoneByValue(79112223344);
    }

    public function testTrue()
    {
        $phys = Phys::factory()
            ->withPhone(['phone' => $value = 79112223344])
            ->create();

        $phone = $phys->getPhoneByValue($value);
        $this->assertInstanceOf(PhysPhone::class, $phone);
    }
}
