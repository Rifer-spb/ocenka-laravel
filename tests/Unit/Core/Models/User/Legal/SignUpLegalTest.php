<?php

namespace Tests\Unit\Core\Models\User\Legal;

use App\Core\Models\Legal\LegalMail;
use App\Core\Models\Legal\LegalPayment;
use App\Core\Models\Legal\LegalProfile;
use App\Core\Models\Legal\LegalWhatsApp;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignUpLegalTest extends TestCase
{
    public function testSignUpSuccess()
    {
        $user = Legal::new(
            $email = new Email('legal@example.com'),
            $password = new Password('password'),
        );

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
        Legal::new(
            new Email('legal@example.com'),
            new Password('password'),
        );

        $this->expectException(QueryException::class);
        $this->expectExceptionMessageMatches('/Duplicate entry|unique constraint|already exists/i');

        Legal::new(
            new Email('legal@example.com'),
            new Password('password'),
        );
    }
}
