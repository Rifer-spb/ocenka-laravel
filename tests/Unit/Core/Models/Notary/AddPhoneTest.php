<?php

namespace Tests\Unit\Core\Models\Notary;

use App\Core\Entities\Notary\Notary;
use App\Core\Entities\Notary\NotaryPhone;
use App\Core\ValueObjects\NationalPhone;
use Tests\TestCase;

class AddPhoneTest extends TestCase
{
    public function testAlreadyExists()
    {
        $notary = Notary::factory()
            ->withPhone($phone = 79112223344)
            ->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Такой номер телефона уже добавлен.');

        $notary->addPhone(new NationalPhone($phone));
    }

    public function testSuccess()
    {
        $notary = Notary::factory()->create();
        $notary->addPhone(new NationalPhone($phone = 79112223344));

        $this->assertCount(1, $notary->phones);
        $this->assertEquals($phone, $notary->phones[0]->phone);

        $notary->refresh();

        $this->assertDatabaseHas(NotaryPhone::class, [
            'notary_id' => $notary->id,
            'phone' => $phone,
        ]);
    }
}
