<?php

namespace Tests\Unit\Core\ValueObjects;

use InvalidArgumentException;
use App\Core\ValueObjects\NationalPhone;
use Tests\TestCase;

class NationalPhoneTest extends TestCase
{
    // ========== УСПЕШНЫЕ СЦЕНАРИИ ==========

    public function testStringWithPlus()
    {
        $phone = new NationalPhone('+79991234567');
        $this->assertEquals('79991234567', $phone->getValue());
    }

    public function testOnlyStringNumbers()
    {
        $phone = new NationalPhone('79991234567');
        $this->assertEquals('79991234567', $phone->getValue());
    }

    public function testOnlyInteger()
    {
        $phone = new NationalPhone(79991234567);
        $this->assertIsString($phone->getValue());
        $this->assertEquals('79991234567', $phone->getValue());
    }

    public function testWithSpaces()
    {
        $phone = new NationalPhone('7 999 123 45 67');
        $this->assertEquals('79991234567', $phone->getValue());
    }

    public function testWithDashes()
    {
        $phone = new NationalPhone('7-999-123-45-67');
        $this->assertEquals('79991234567', $phone->getValue());
    }

    public function testWithBrackets()
    {
        $phone = new NationalPhone('+7 (999) 123-45-67');
        $this->assertEquals('79991234567', $phone->getValue());
    }

    public function testWithOutSevenBefore()
    {
        $phone = new NationalPhone('9991234567');
        $this->assertEquals('79991234567', $phone->getValue());
    }

    public function testWithEightBeforeConvertsToSeven()
    {
        $phone = new NationalPhone('89991234567');
        $this->assertEquals('79991234567', $phone->getValue());
    }

    public function testWith8AndDashes()
    {
        $phone = new NationalPhone('8-999-123-45-67');
        $this->assertEquals('79991234567', $phone->getValue());
    }

    public function testAccepts7_999_123_45_67()
    {
        $phone = new NationalPhone('7 999 123 45 67');
        $this->assertEquals('79991234567', $phone->getValue());
    }

    public function testAccepts8_999_123_45_67()
    {
        $phone = new NationalPhone('8 999 123 45 67');
        $this->assertEquals('79991234567', $phone->getValue());
    }

    public function testMixedLettersAndNumbers()
    {
        $phone = new NationalPhone('abc9991234567');
        $this->assertEquals('79991234567', $phone->getValue());
    }

    // ========== ОШИБКИ ==========

    public function testEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Пустой номер телефона.');

        new NationalPhone('');
    }

    public function testTooShort()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Некорректный номер телефона.');

        new NationalPhone('123456789'); // 9 цифр
    }

    public function testTooLong()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Некорректный номер телефона.');

        new NationalPhone('123456789012'); // 12 цифр
    }

    public function testNotStartingWith7Or8()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Некорректный номер телефона.');

        new NationalPhone('99991234567'); // начинается с 9
    }

    public function testOnlyLetters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Некорректный номер телефона.');
        new NationalPhone('abcdefghijk');
    }
}
