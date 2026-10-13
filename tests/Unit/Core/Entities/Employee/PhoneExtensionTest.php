<?php

namespace Tests\Unit\Core\Entities\Employee;

use App\Core\Entities\Employee\PhoneExtension;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(PhoneExtension::class)]
class PhoneExtensionTest extends TestCase
{
    public function testWithNUll(): void
    {
        $extension = new PhoneExtension(null);

        $this->assertNull($extension->getValue());
    }

    public function testWithEmptyString(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный добавочный номер.');

        new PhoneExtension('');
    }

    public function testWithWhitespace(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный добавочный номер.');

        new PhoneExtension('   ');
    }

    public function testWithTabsAndNewlines(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный добавочный номер.');

        new PhoneExtension("\t\n\r");
    }

    public function testWithCharacters(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный добавочный номер.');

        new PhoneExtension('abc');
    }

    public function testSuccessWithOnlyNumber(): void
    {
        $extension = new PhoneExtension('123');

        $this->assertEquals('123', $extension->getValue());
    }

    public function testTrim(): void
    {
        $extension = new PhoneExtension('  123  ');

        $this->assertEquals('123', $extension->getValue());
    }

    public function testMaxLength(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный добавочный номер.');

        new PhoneExtension('12345');
    }

    public function testWithSingleDigit(): void
    {
        $extension = new PhoneExtension('5');

        $this->assertEquals('5', $extension->getValue());
    }

    public function testWithZeroString(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный добавочный номер.');

        new PhoneExtension('0');
    }

    public function testSuccessWithZeroFirst(): void
    {
        $extension = new PhoneExtension('001');

        $this->assertEquals('001', $extension->getValue());
    }
}
