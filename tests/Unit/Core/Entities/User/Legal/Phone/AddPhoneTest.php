<?php

namespace Tests\Unit\Core\Entities\User\Legal\Phone;

use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Legal\LegalPhone;
use App\Core\ValueObjects\NationalPhone;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Legal::class, 'addPhone')]
class AddPhoneTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $user = Legal::factory()->create();

        $phone = new NationalPhone($value = '79876543210');
        $phone = $user->addPhone($phone);

        $this->assertTrue($user->hasPhone($value));
        $this->assertDatabaseHas(LegalPhone::getTableName(), [
            'id' => $phone->id,
            'legal_id' => $user->id,
            'phone' => $value,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function testAlreadyExists()
    {
        $user = Legal::factory()
            ->withPhone(['phone' => $value = '79876543210'])
            ->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Такой номер уже добавлен.');

        $user->addPhone(new NationalPhone($value));
    }
}
