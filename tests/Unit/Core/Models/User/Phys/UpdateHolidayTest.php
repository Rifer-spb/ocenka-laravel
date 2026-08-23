<?php

namespace Tests\Unit\Core\Models\User\Phys;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\Phys\ValueObjects\Holiday;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Tests\TestCase;

class UpdateHolidayTest extends TestCase
{
    public function testFilledSuccess()
    {
        $user = $this->createUser();

        $user->updateHoliday(
            new Holiday($from = '01.08.2026', $to = '10.08.2026')
        );

        $user = Phys::findOrFail($user->id);

        $this->assertEquals($user->profile->holiday_from, $from);
        $this->assertEquals($user->profile->holiday_to, $to);
    }

    public function testWithEmpty()
    {
        $user = $this->createUser();

        $user->updateHoliday(
            new Holiday('', '')
        );

        $user = Phys::findOrFail($user->id);

        $this->assertEmpty($user->profile->holiday_from);
        $this->assertEmpty($user->profile->holiday_to);
    }

    public function testWithNull()
    {
        $user = $this->createUser();

        $user->updateHoliday(
            new Holiday(null, null)
        );

        $user = Phys::findOrFail($user->id);

        $this->assertEmpty($user->profile->holiday_from);
        $this->assertEmpty($user->profile->holiday_to);
    }

    public function createUser(): Phys
    {
        return Phys::new(
            new Email('phys@example.com'),
            new Password('password'),
        );
    }
}
