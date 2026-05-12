<?php

namespace Tests\Unit\User;

use App\Core\Models\Legal\LegalMail;
use App\Core\Models\Legal\LegalPayment;
use App\Core\Models\Legal\LegalProfile;
use App\Core\Models\Legal\LegalWhatsApp;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Role;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignUpLegalTest extends TestCase
{
    use RefreshDatabase;

    public function test_sign_up_success()
    {
        $user = Legal::signUpManager(
            $email = 'legal@example.com',
            $password = 'remote98',
            $role = Role::LEGAL->value,
        );

        $this->assertEquals($email, $user->username);
        $this->assertEquals($email, $user->email);
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertEquals($role, $user->role);
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

    public function test_already_exists_email()
    {
        Legal::signUpManager('legal@example.com', 'remote98', Role::LEGAL->value);

        $this->expectException(QueryException::class);

        Legal::signUpManager('legal@example.com', 'remote98', Role::LEGAL->value);
    }
}
