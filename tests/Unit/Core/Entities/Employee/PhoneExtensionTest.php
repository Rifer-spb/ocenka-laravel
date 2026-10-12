<?php

namespace Tests\Unit\Core\Entities\Employee;

use App\Core\Entities\Employee\PhoneExtension;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(PhoneExtension::class)]
class PhoneExtensionTest extends TestCase
{
    public function testNullReturnsNull(): void
    {
        $extension = new PhoneExtension(null);

        $this->assertNull($extension->getValue());
    }

    public function testEmptyStringReturnsNull(): void
    {
        $extension = new PhoneExtension('');

        $this->assertNull($extension->getValue());
    }

    public function testWhitespaceOnlyReturnsNull(): void
    {
        $extension = new PhoneExtension('   ');

        $this->assertNull($extension->getValue());
    }

    public function testTabsAndNewlinesReturnNull(): void
    {
        $extension = new PhoneExtension("\t\n\r");

        $this->assertNull($extension->getValue());
    }

    public function testNonNumericCharactersAreRemoved(): void
    {
        $extension = new PhoneExtension('abc');

        $this->assertNull($extension->getValue());
    }

    public function testSuccess(): void
    {
        $extension = new PhoneExtension('123');

        $this->assertEquals('123', $extension->getValue());
    }

    public function testTrim(): void
    {
        $extension = new PhoneExtension('  123  ');

        $this->assertEquals('123', $extension->getValue());
    }

    public function testOnlyNumbersExtractedFromLetters(): void
    {
        $extension = new PhoneExtension('abc123def45');

        $this->assertEquals('12345', $extension->getValue());
    }

    public function testMaxLength5Allowed(): void
    {
        $extension = new PhoneExtension('12345');

        $this->assertEquals('12345', $extension->getValue());
    }

    public function testLengthGreaterThan5Throws(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный добавочный номер.');

        new PhoneExtension('123456');
    }

    public function testLengthGreaterThan5ThrowsAfterExtraction(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный добавочный номер.');

        // После извлечения цифр останется 123456789 (9 символов)
        new PhoneExtension('+7 (999) 123-45-6789');
    }

    public function testSingleDigit(): void
    {
        $extension = new PhoneExtension('5');

        $this->assertEquals('5', $extension->getValue());
    }

    public function testZeroIsPreserved(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный добавочный номер.');

        new PhoneExtension('0');
    }

    public function testLeadingZerosArePreserved(): void
    {
        $extension = new PhoneExtension('00123');

        $this->assertEquals('123', $extension->getValue());
    }
}
