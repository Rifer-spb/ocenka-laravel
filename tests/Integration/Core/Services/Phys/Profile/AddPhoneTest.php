<?php

namespace Tests\Integration\Core\Services\Phys\Profile;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Services\PhysProfileService;
use App\Core\ValueObjects\NationalPhone;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(PhysProfileService::class, 'addPhone')]
class AddPhoneTest extends TestCase
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

        $this->service->addPhone(111, new NationalPhone(79112223344));
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $phys = Phys::factory()->create();

        $this->service->addPhone($phys->id, new NationalPhone($phone = 79112223344));
        $phys->refresh();

        $this->assertCount(1, $phys->phones);
        $this->assertEquals($phone, $phys->phones[0]->phone);
    }
}
