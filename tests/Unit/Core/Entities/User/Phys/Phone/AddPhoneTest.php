<?php

namespace Tests\Unit\Core\Entities\User\Phys\Phone;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\Phys\PhysPhone;
use App\Core\ValueObjects\NationalPhone;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Phys::class, 'addPhone')]
class AddPhoneTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $user = Phys::factory()->create();

        $phone = new NationalPhone($value = '79876543210');
        $phone = $user->addPhone($phone);

        $this->assertTrue($user->hasPhone($value));
        $this->assertDatabaseHas(PhysPhone::getTableName(), [
            'id' => $phone->id,
            'user_id' => $user->id,
            'phone' => $value,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function testAlreadyExists()
    {
        $user = Phys::factory()
            ->withPhone(['phone' => $value = '79876543210'])
            ->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Номер телефона уже добавлен.');

        $user->addPhone(new NationalPhone($value));
    }
}
