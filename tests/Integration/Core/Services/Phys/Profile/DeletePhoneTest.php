<?php

namespace Tests\Integration\Core\Services\Phys\Profile;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Services\PhysProfileService;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(PhysProfileService::class, 'deletePhone')]
class DeletePhoneTest extends TestCase
{
    private PhysProfileService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(PhysProfileService::class);
    }

    /**
     * @throws \Throwable
     */
    public function testInvalidPhysId()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Физ.лицо не найдено.');

        $this->service->deletePhone(111, 222);
    }

    /**
     * @throws \Throwable
     */
    public function testInvalidPhoneId()
    {
        $phys = Phys::factory()->create();

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Телефон не найден.');

        $this->service->deletePhone($phys->id, 222);
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $phys = Phys::factory()->withPhone()->create();
        $phone = $phys->phones[0];

        $this->service->deletePhone($phys->id, $phone->id);
        $phys->refresh();

        $this->assertCount(0, $phys->phones);
    }
}
