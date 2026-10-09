<?php

namespace Tests\Unit\Core\Entities\User\Phys;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\Phys\PhysProfile;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function testSignUpSuccess()
    {
        $user = Phys::createNew(
            $email = new Email('phys@example.com'),
            $password = new Password('password'),
        );

        $user = Phys::findOrFail($user->id);

        $this->assertEquals($email->getValue(), $user->username);
        $this->assertEquals($email->getValue(), $user->email);
        $this->assertTrue($user->isPhys());

        $this->assertNotEmpty($user->email_verify_token);
        $this->assertEquals(60, Str::length($user->email_verify_token));

        $passwordHashCheck = Hash::check($password->getValue(), $user->password);
        $this->assertTrue($passwordHashCheck);

        $this->assertNotNull($user->profile);
        $this->assertInstanceOf(PhysProfile::class, $user->profile);
    }

    public function testAlreadyExistsEmail()
    {
        $email = 'phys@example.com';

        Phys::factory()
            ->state(['username' => $email, 'email' => $email])
            ->create();

        $this->expectException(QueryException::class);
        $this->expectExceptionMessageMatches('/Duplicate entry|unique/i');

        Phys::createNew(
            new Email('phys@example.com'),
            new Password('password'),
        );
    }
}
