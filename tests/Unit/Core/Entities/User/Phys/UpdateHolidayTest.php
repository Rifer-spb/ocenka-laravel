<?php

namespace Tests\Unit\Core\Entities\User\Phys;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\Phys\ValueObjects\Holiday;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Phys::class, 'updateHoliday')]
class UpdateHolidayTest extends TestCase
{
    /**
     * @return void
     * @throws \Throwable
     */
    public function testFilledSuccess()
    {
        $user = $this->createUser();
        $user->updateHoliday(new Holiday($from = '01.08.2026', $to = '10.08.2026'));

        $user = Phys::findOrFail($user->id);
        $this->assertEquals($user->profile->holiday_from, $from);
        $this->assertEquals($user->profile->holiday_to, $to);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testWithEmpty()
    {
        $user = $this->createUser();
        $user->updateHoliday(new Holiday('', ''));

        $user = Phys::findOrFail($user->id);
        $this->assertEmpty($user->profile->holiday_from);
        $this->assertEmpty($user->profile->holiday_to);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testWithNull()
    {
        $user = $this->createUser();
        $user->updateHoliday(new Holiday(null, null));

        $user = Phys::findOrFail($user->id);
        $this->assertEmpty($user->profile->holiday_from);
        $this->assertEmpty($user->profile->holiday_to);
    }

    public function createUser(): Phys
    {
        return Phys::factory()->withProfile()->create();
    }
}
