<?php

namespace Tests\Unit\Core\Models\User\Phys;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\Phys\PhysProfile;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignUpPhysTest extends TestCase
{
    use RefreshDatabase;

    public function testSignUpSuccess()
    {
        $user = Phys::new(
            $email = new Email('phys@example.com'),
            $password = new Password('password'),
        );

        $this->assertEquals($email->getValue(), $user->email);
        $this->assertTrue(Hash::check($password->getValue(), $user->password));
        $this->assertTrue($user->isPhys());

        $this->assertDatabaseHas(PhysProfile::getTableName(), ['id' => $user->id]);
        $this->assertNotNull($user->profile);
        $this->assertInstanceOf(PhysProfile::class, $user->profile);
    }

    public function testAlreadyExistsEmail()
    {
        Phys::new(
            new Email('phys@example.com'),
            new Password('password'),
        );

        $this->expectException(QueryException::class);
        $this->expectExceptionMessageMatches('/Duplicate entry|unique/i');

        Phys::new(
            new Email('phys@example.com'),
            new Password('password'),
        );
    }
}
