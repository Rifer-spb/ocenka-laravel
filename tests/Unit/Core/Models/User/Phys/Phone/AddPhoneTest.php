<?php

namespace Tests\Unit\Core\Models\User\Phys\Phone;

use App\Core\Models\User\Phys\Phys;
use App\Core\ValueObjects\NationalPhone;
use Tests\TestCase;

class AddPhoneTest extends TestCase
{
    public function testSuccess()
    {
        $user = Phys::factory()->create();

        $phone = new NationalPhone($value = '79876543210');
        $user->addPhone($phone);

        $user = Phys::findOrFail($user->id);
        $this->assertTrue($user->hasPhone($value));
    }

    public function testAlreadyExists()
    {
        $user = Phys::factory()
            ->withPhone(['phone' => $value = '79876543210'])
            ->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Номер телефона {$value} уже добавлен.");

        $user->addPhone(new NationalPhone($value));
    }
}
