<?php

namespace Tests\Unit\Core\Models\User\Phys\Phone;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\NationalPhone;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class DeletePhoneTest extends TestCase
{
    public function testNotExist()
    {
        $user = $this->createUser();
        $this->expectException(ModelNotFoundException::class);
        $user->deletePhone(999);
    }

    public function testSuccess()
    {
        $user = $this->createUser();
        $phone = $user->addPhone(new NationalPhone($value = '79876543210'));
        $this->assertTrue($user->hasPhone($value));

        $user->deletePhone($phone->id);

        $user = Phys::findOrFail($user->id);
        $this->assertTrue(!$user->hasPhone($value));
    }

    public function testDeleteByIdFromAnotherUser()
    {
        $user = $this->createUser();
        $anotherUser = Phys::new(
            new Email('another@test.com'),
            new Password('password'),
        );
        $anotherUserPhone = $anotherUser->addPhone(new NationalPhone('79876543210'));

        $this->expectException(ModelNotFoundException::class);
        $user->deletePhone($anotherUserPhone->id);
    }

    private function createUser(): Phys
    {
        return Phys::new(
            new Email('test@test.com'),
            new Password('password'),
        );
    }
}
