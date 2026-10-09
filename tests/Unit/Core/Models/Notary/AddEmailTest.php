<?php

namespace Tests\Unit\Core\Models\Notary;

use App\Core\Entities\Notary\Notary;
use App\Core\Entities\Notary\NotaryEmail;
use App\Core\ValueObjects\Email;
use Tests\TestCase;

class AddEmailTest extends TestCase
{
    public function testAlreadyExists()
    {
        $notary = Notary::factory()
            ->withEmail($email = 'exist-email@test.ru')
            ->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Такой e-mail уже добавлен.');

        $notary->addEmail(new Email($email));
    }

    public function testSuccess()
    {
        $notary = Notary::factory()->create();
        $notary->addEmail(new Email($email = 'exist-email@test.ru'));

        $this->assertCount(1, $notary->emails);
        $this->assertEquals($email, $notary->emails[0]->email);

        $notary->refresh();

        $this->assertDatabaseHas(NotaryEmail::class, [
            'notary_id' => $notary->id,
            'email' => $email,
        ]);
    }
}
