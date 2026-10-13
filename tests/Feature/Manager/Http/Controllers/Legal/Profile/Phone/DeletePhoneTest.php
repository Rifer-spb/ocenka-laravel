<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Profile\Phone;

use App\Core\Entities\User\Legal\Legal;
use App\Core\ValueObjects\NationalPhone;
use App\Manager\Http\Controllers\Legal\ProfileController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(ProfileController::class,'deletePhone')]
class DeletePhoneTest extends TestCase
{
    public function testNotExist()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->delete($this->getRoute(999));

        $response->assertStatus(404);
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $user = $this->createUser();
        $phone = $user->addPhone(new NationalPhone(79998887766));

        $response = $this->actingAs($user)
            ->delete($this->getRoute($phone->id));

        $response->assertSessionHas('success', 'Успешно удалено');

        $user->refresh();
        $this->assertFalse($user->hasPhone(79998887766));
    }

    private function getRoute(int $id): string
    {
        return route('manager.legal.profile.phones.delete', ['phone' => $id]);
    }

    private function createUser(): Legal
    {
        return Legal::factory()->create();
    }
}
