<?php

namespace Tests\Unit\Core\Models\User\ValueObjects;

use InvalidArgumentException;
use App\Core\Models\User\ValueObjects\FirstName;
use Tests\TestCase;

class NamePartTest extends TestCase
{
    // ==================== УСПЕШНЫЕ СЦЕНАРИИ ====================

    public function testValidWithOnlySpace()
    {
        $name = new FirstName('   ');
        $this->assertEquals('', $name->getValue());
    }

    public function testValidRussianName()
    {
        $name = new FirstName('Александр');
        $this->assertEquals('Александр', $name->getValue());
    }

    public function testValidEnglishName()
    {
        $name = new FirstName('John');
        $this->assertEquals('John', $name->getValue());
    }

    public function testValidNameWithHyphen()
    {
        $name = new FirstName('Анна-Мария');
        $this->assertEquals('Анна Мария', $name->getValue());
    }

    public function testValidNameWithOnlyHyphen()
    {
        $name = new FirstName('-');
        $this->assertEquals('', $name->getValue());
    }

    public function testValidNameWithMultipleHyphen()
    {
        $name = new FirstName('---Анна----Мария--');
        $this->assertEquals('Анна Мария', $name->getValue());
    }

    public function testValidNameWithSpace()
    {
        $name = new FirstName('Анна Мария');
        $this->assertEquals('Анна Мария', $name->getValue());
    }

    public function testNameWithMultipleSpacesIsTrimmed()
    {
        $name = new FirstName('   Анна   Мария   ');
        $this->assertEquals('Анна Мария', $name->getValue());
    }

    public function testNameWithMultipleSpacesAndHyphen()
    {
        $name = new FirstName(' --  Анна  - --- Мария -  ');
        $this->assertEquals('Анна Мария', $name->getValue());
    }

    public function testMixedRussianAndEnglishName()
    {
        $name = new FirstName('John Александр');
        $this->assertEquals('John Александр', $name->getValue());
    }

    public function testNameWithUppercaseLetters()
    {
        $name = new FirstName('ALEXANDER');
        $this->assertEquals('ALEXANDER', $name->getValue());
    }

    public function testNameWithLowercaseLetters()
    {
        $name = new FirstName('alexander');
        $this->assertEquals('alexander', $name->getValue());
    }

    public function testNameWithYo()
    {
        $name = new FirstName('Алёна');
        $this->assertEquals('Алёна', $name->getValue());

        $name = new FirstName('Ёлка');
        $this->assertEquals('Ёлка', $name->getValue());
    }

    public function testNameWithOnlyOneVar()
    {
        $name = new FirstName('А');
        $this->assertEquals('А', $name->getValue());
    }

    public function testRemoveAllInvalidCharacters()
    {
        $name = new FirstName('!@#$%^&*()_+={}[]|\\:;"\'<>,.?/~`');
        $this->assertEquals('', $name->getValue());
    }

    public function testRemoveAllInvalidCharactersWithNumbers()
    {
        $name = new FirstName('1234567890');
        $this->assertEquals('', $name->getValue());
    }

    public function testRemoveAllInvalidCharactersMixed()
    {
        $name = new FirstName('!@# 123 $%^ &*()');
        $this->assertEquals('', $name->getValue());
    }

    public function testMagicString()
    {
        $name = new FirstName('Александр');
        $this->assertEquals('Александр', $name->getValue());
    }

    // ==================== ОШИБКИ ВАЛИДАЦИИ ====================

    public function testNameExceedsMaxLengthThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Значение поля Имя не должно превышать 100 символов.');
        new FirstName(str_repeat('а', 101));
    }
}
