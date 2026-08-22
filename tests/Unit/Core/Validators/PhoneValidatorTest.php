<?php

namespace Tests\Unit\Core\Validators;

use App\Core\Validators\PhoneValidator;
use Tests\TestCase;

class PhoneValidatorTest extends TestCase
{
    public function testInvalidWith123()
    {
        $this->assertFalse(PhoneValidator::isNational(123));
    }

    public function testInvalidWithEmptyString()
    {
        $this->assertFalse(PhoneValidator::isNational(''));
    }

    public function testInvalidWithLarge()
    {
        $this->assertFalse(PhoneValidator::isNational(1234567891011));
    }

    public function testValidWith10()
    {
        $this->assertTrue(PhoneValidator::isNational(1234567891));
    }

    public function testInvalidWithout7Or8With11()
    {
        $this->assertFalse(PhoneValidator::isNational(12345678911));
    }

    public function testValidWith7()
    {
        $this->assertTrue(PhoneValidator::isNational(79998887766));
    }

    public function testValidWith8()
    {
        $this->assertTrue(PhoneValidator::isNational(89998887766));
    }
}
