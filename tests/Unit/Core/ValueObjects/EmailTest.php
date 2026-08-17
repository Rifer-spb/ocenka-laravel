<?php

namespace Tests\Unit\Core\ValueObjects;

use App\Core\ValueObjects\Email;
use InvalidArgumentException;
use Tests\TestCase;

class EmailTest extends TestCase
{
    public function testEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Не указан e-mail.');

        new Email('');
    }

    public function testInvalid()
    {
        $email = 'invalid-email';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Некорректный e-mail: {$email}");

        new Email($email);
    }

    public function testTrim()
    {
        $email = new Email('     valid@email.com     ');
        $this->assertEquals('valid@email.com', $email->getValue());
    }

    public function testValid()
    {
        $email = new Email('valid@email.com');
        $this->assertEquals('valid@email.com', $email->getValue());
    }
}
