<?php

namespace Tests\Unit\Core\Models\User\Phys\Phone;

use App\Core\Entities\User\Phys\Phys;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class DeletePhoneTest extends TestCase
{
    public function testNotExist()
    {
        $user = Phys::factory()->create();
        $this->expectException(ModelNotFoundException::class);
        $user->deletePhone(999);
    }

    public function testSuccess()
    {
        $user = Phys::factory()
            ->withPhone(['phone' => $value = '79876543210'])
            ->create();

        $user = Phys::findOrFail($user->id);
        $phone = $user->getPhoneByValue($value);
        $user->deletePhone($phone->id);

        $this->assertTrue(!$user->hasPhone($value));
    }

    public function testDeleteByIdFromAnotherUser()
    {
        $user = Phys::factory()->create();
        $anotherUser = Phys::factory()
            ->withPhone(['phone' => $value = '79876543210'])
            ->create();

        $anotherUserPhone = $anotherUser->getPhoneByValue($value);

        $this->expectException(ModelNotFoundException::class);
        $user->deletePhone($anotherUserPhone->id);
    }
}
