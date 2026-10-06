<?php

namespace Tests\Unit\Core\Models\User;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
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
