<?php

namespace Tests\Unit\Core\Entities\User\Legal;

use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Legal\LegalMail;
use App\Core\Entities\User\Legal\LegalPayment;
use App\Core\Entities\User\Legal\LegalProfile;
use App\Core\Entities\User\Legal\LegalWhatsApp;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function testSignUpSuccess()
    {
        $user = Legal::createNew(
            $email = new Email('legal@example.com'),
            $password = new Password('password'),
        );

        $user = Legal::findOrFail($user->id);

        $this->assertEquals($email->getValue(), $user->username);
        $this->assertEquals($email->getValue(), $user->email);
        $this->assertTrue(Hash::check($password->getValue(), $user->password));
        $this->assertTrue($user->isLegal());
        $this->assertNotNull($user->email_verify_token);

        $this->assertDatabaseHas(LegalProfile::getTableName(), ['id' => $user->id]);
        $this->assertNotNull($user->profile);
        $this->assertInstanceOf(LegalProfile::class, $user->profile);

        $this->assertDatabaseHas(LegalPayment::getTableName(), ['id' => $user->id]);
        $this->assertNotNull($user->payment);
        $this->assertInstanceOf(LegalPayment::class, $user->payment);

        $this->assertDatabaseHas(LegalMail::getTableName(), ['id' => $user->id]);
        $this->assertNotNull($user->mail);
        $this->assertInstanceOf(LegalMail::class, $user->mail);

        $this->assertDatabaseHas(LegalWhatsApp::getTableName(), ['id' => $user->id]);
        $this->assertNotNull($user->whatsApp);
        $this->assertInstanceOf(LegalWhatsApp::class, $user->whatsApp);
    }

    public function testAlreadyExistsEmail()
    {
        $email = 'legal@example.com';

        Legal::factory()->state([
            'email' => $email,
            'username' => $email
        ])->create();

        $this->expectException(QueryException::class);
        $this->expectExceptionMessageMatches('/Duplicate entry|unique constraint|already exists/i');

        Legal::createNew(
            new Email('legal@example.com'),
            new Password('password'),
        );
    }
}
