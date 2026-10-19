<?php

namespace Tests\Unit\Core\Entities\User\Phys\Phone;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\Phys\PhysPhone;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Phys::class, 'deletePhone')]
class DeletePhoneTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testNotExist()
    {
        $phys = Phys::factory()->create();
        $this->expectException(EntityNotFoundException::class);
        $phys->deletePhone(999);
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $phys = Phys::factory()->withPhone()->create();

        $phone = array_reverse($phys->phones->all())[0];
        $phys->deletePhone($phone->id);

        $this->assertCount(0, $phys->phones);
        $this->assertDatabaseMissing(PhysPhone::getTableName(), [
            'id' => $phone->id,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function testDeleteByIdFromAnotherUser()
    {
        $user = Phys::factory()->create();
        $anotherUser = Phys::factory()
            ->withPhone(['phone' => '79876543210'])
            ->create();

        $anotherUserPhone = array_reverse($anotherUser->phones->all())[0];

        $this->expectException(EntityNotFoundException::class);
        $user->deletePhone($anotherUserPhone->id);
    }
}
