<?php

namespace Tests\Unit\User;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\Phys\PhysProfile;
use App\Core\Models\User\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignUpPhysTest extends TestCase
{
    use RefreshDatabase;

    public function test_sign_up_success()
    {
        $user = Phys::signUpManager(
            $email = 'phys@example.com',
            $password = 'remote98',
            $role = Role::PHYS->value,
        );

        $this->assertEquals($email, $user->email);
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertEquals($role, $user->role);
        $this->assertTrue($user->isPhys());

        $this->assertDatabaseHas(PhysProfile::getTableName(), ['id' => $user->id]);
        $this->assertNotNull($user->profile);
        $this->assertInstanceOf(PhysProfile::class, $user->profile);
    }
}
