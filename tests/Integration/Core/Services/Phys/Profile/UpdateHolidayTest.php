<?php

namespace Tests\Integration\Core\Services\Phys\Profile;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\Phys\ValueObjects\Holiday;
use App\Core\Services\PhysProfileService;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(PhysProfileService::class, 'updateHoliday')]
class UpdateHolidayTest extends TestCase
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

        $this->service->updateHoliday(111, new Holiday('',''));
    }

    /**
     * @throws \Throwable
     */
    public function testSuccessWithFilled()
    {
        $phys = Phys::factory()->withProfile()->create();

        $dateFrom = '01.06.2019';
        $dateTo = '01.09.2019';

        $this->service->updateHoliday($phys->id, new Holiday($dateFrom,$dateTo));
        $phys->refresh();

        $this->assertEquals($dateFrom, $phys->profile->holiday_from);
        $this->assertEquals($dateTo, $phys->profile->holiday_to);
    }

    /**
     * @throws \Throwable
     */
    public function testSuccessWithEmpty()
    {
        $phys = Phys::factory()->withProfile([
            'holiday_from' => CarbonImmutable::parse('01.06.2019'),
            'holiday_to' => CarbonImmutable::parse('01.09.2019'),
        ])->create();

        $this->service->updateHoliday($phys->id, new Holiday(null, null));
        $phys->refresh();

        $this->assertNull($phys->profile->holiday_from);
        $this->assertNull($phys->profile->holiday_to);
    }
}
