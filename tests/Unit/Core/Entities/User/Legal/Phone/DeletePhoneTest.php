<?php

namespace Tests\Unit\Core\Entities\User\Legal\Phone;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Legal\LegalPhone;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Legal::class, 'deletePhone')]
class DeletePhoneTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testNotExist()
    {
        $user = Legal::factory()->create();
        $this->expectException(EntityNotFoundException::class);
        $user->deletePhone(999);
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $user = Legal::factory()->withPhone()->create();

        $phone = array_reverse($user->phones->all())[0];
        $user->deletePhone($phone->id);

        $this->assertCount(0, $user->phones);
        $this->assertDatabaseMissing(LegalPhone::getTableName(), [
            'id' => $phone->id,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function testDeleteByIdFromAnotherUser()
    {
        $user = Legal::factory()->create();
        $anotherUser = Legal::factory()->withPhone()->create();

        $anotherUserPhone = array_reverse($anotherUser->phones->all())[0];

        $this->expectException(EntityNotFoundException::class);
        $user->deletePhone($anotherUserPhone->id);
    }
}
