<?php

namespace Tests\Unit\Core\Entities\User\Phys\ValueObjects;

use Carbon\Carbon;
use Tests\TestCase;
use InvalidArgumentException;
use App\Core\Entities\User\Phys\ValueObjects\Holiday;

class HolidayTest extends TestCase
{
    // ==================== ПУСТЫЕ ЗНАЧЕНИЯ ====================

    public function testWithEmptyString()
    {
        $holiday = new Holiday('', '');

        $this->assertNull($holiday->getFrom());
        $this->assertNull($holiday->getTo());
        $this->assertNull($holiday->getFromString());
        $this->assertNull($holiday->getToString());
    }

    public function testWithNull()
    {
        $holiday = new Holiday(null, null);

        $this->assertNull($holiday->getFrom());
        $this->assertNull($holiday->getTo());
        $this->assertNull($holiday->getFromString());
        $this->assertNull($holiday->getToString());
    }

    // ==================== ВАЛИДНЫЕ ЗНАЧЕНИЯ ====================

    public function testValidHoliday()
    {
        $holiday = new Holiday($from = '2026-08-01', $to = '2026-08-10');

        $this->assertInstanceOf(Carbon::class, $holiday->getFrom());
        $this->assertInstanceOf(Carbon::class, $holiday->getTo());
        $this->assertEquals($from, $holiday->getFromString());
        $this->assertEquals($to, $holiday->getToString());
    }

    public function testValidHolidayWithTrim()
    {
        $holiday = new Holiday('  2026-08-01  ', '  2026-08-10  ');

        $this->assertEquals('2026-08-01', $holiday->getFromString());
        $this->assertEquals('2026-08-10', $holiday->getToString());
    }

    // ==================== НЕВАЛИДНЫЕ ЗНАЧЕНИЯ ====================

    public function testFromMustBeBeforeTo()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Дата окончания отпуска должна быть позже даты начала');

        new Holiday('2026-08-10', '2026-08-01');
    }

    public function testSameDayThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Дата окончания отпуска должна быть позже даты начала');

        new Holiday('2026-08-01', '2026-08-01');
    }

    // ==================== ГЕТТЕРЫ ====================

    public function testGetFromStringReturnsString()
    {
        $holiday = new Holiday($from = '2026-08-01', '2026-08-10');

        $this->assertIsString($holiday->getFromString());
        $this->assertEquals($from, $holiday->getFromString());
    }

    public function testGetToStringReturnsString()
    {
        $holiday = new Holiday('2026-08-01', $to = '2026-08-10');

        $this->assertIsString($holiday->getToString());
        $this->assertEquals($to, $holiday->getToString());
    }

    // ==================== ГРАНИЧНЫЕ СЛУЧАИ ====================

    public function testHolidayWithSpacesOnly()
    {
        $holiday = new Holiday('  ', '  ');

        $this->assertNull($holiday->getFrom());
        $this->assertNull($holiday->getTo());
    }

    public function testHolidayWithMixedEmpty()
    {
        $holiday = new Holiday('2026-08-01', '');

        $this->assertNull($holiday->getFrom());
        $this->assertNull($holiday->getTo());
    }

    public function testHolidayWithWhitespaceAndValidDate()
    {
        $holiday = new Holiday("  \n  2026-08-01  \t  ", "  \n  2026-08-10  \t  ");

        $this->assertEquals('2026-08-01', $holiday->getFromString());
        $this->assertEquals('2026-08-10', $holiday->getToString());
    }
}
