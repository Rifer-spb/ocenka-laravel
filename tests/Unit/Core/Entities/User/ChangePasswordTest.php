<?php

namespace Tests\Unit\Core\Entities\User;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Phys::class, 'updatePassword')]
class ChangePasswordTest extends TestCase
{
    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $user = Phys::createNew(
            new Email('test@test.com'),
            new Password('password')
        );

        $user->updatePassword(new Password($password = 'new-password'));
        $user->saveOrFail();

        $user = Phys::findOrFail($user->id);
        $this->assertTrue(Hash::check($password, $user->password));
    }
}
