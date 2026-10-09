<?php

namespace Tests\Unit\Core\Entities\User\ValueObjects;

use App\Core\Entities\User\ValueObjects\Password;
use Tests\TestCase;
use InvalidArgumentException;

class PasswordTest extends TestCase
{
    public function testEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Пароль должен быть не менее 8 символов.');

        new Password('');
    }

    public function testMinLength()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Пароль должен быть не менее 8 символов.');

        new Password('abc-123');
    }

    public function testMaxLength()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Пароль не может быть длиннее 50 символов.');

        new Password('abc-123-abc-123-abc-123-abc-123-abc-123-abc-123-abc-123-abc-123');
    }

    public function testTrim()
    {
        $password = new Password('   abc-123-abc   ');

        $this->assertEquals('abc-123-abc', $password->getValue());
    }

    public function testValid()
    {
        $password = new Password('abc-123-abc');

        $this->assertEquals('abc-123-abc', $password->getValue());
    }
}
