<?php

namespace Tests\Unit\Core\Validators;

use App\Core\Validators\EmailValidator;
use Tests\TestCase;

class EmailValidatorTest extends TestCase
{
    public function testSuccess(): void
    {
        $this->assertTrue(EmailValidator::isEmail('user@example.com'));
    }

    public function testWithDotsInLocalPart(): void
    {
        $this->assertTrue(EmailValidator::isEmail('first.last@example.com'));
    }

    public function testWithPlusTag(): void
    {
        $this->assertTrue(EmailValidator::isEmail('user+tag@example.com'));
    }

    public function testSubdomain(): void
    {
        $this->assertTrue(EmailValidator::isEmail('user@mail.example.co.uk'));
    }

    public function testEmpty(): void
    {
        $this->assertFalse(EmailValidator::isEmail(''));
    }

    public function testWithoutAtSign(): void
    {
        $this->assertFalse(EmailValidator::isEmail('plainaddress'));
    }

    public function testWithoutLocalPart(): void
    {
        $this->assertFalse(EmailValidator::isEmail('@example.com'));
    }

    public function testWithoutDomain(): void
    {
        $this->assertFalse(EmailValidator::isEmail('user@'));
    }

    public function testTwoAtSigns(): void
    {
        $this->assertFalse(EmailValidator::isEmail('user@@example.com'));
    }

    public function testWithSpaceInside(): void
    {
        $this->assertFalse(EmailValidator::isEmail('user name@example.com'));
    }

    public function testCyrillicLocalPartIsNotSupported(): void
    {
        $this->assertFalse(EmailValidator::isEmail('почта@example.com'));
    }
}
