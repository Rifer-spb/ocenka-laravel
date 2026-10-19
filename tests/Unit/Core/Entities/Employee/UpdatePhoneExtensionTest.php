<?php

namespace Tests\Unit\Core\Entities\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\Employee\PhoneExtension;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Employee::class,'updatePhoneExtension')]
class UpdatePhoneExtensionTest extends TestCase
{
    public function testWithString()
    {
        $employee = Employee::factory()->create();
        $employee->updatePhoneExtension(new PhoneExtension($extension = '101'));

        $this->assertEquals($extension, $employee->phone_extension);
    }

    public function testWithInteger()
    {
        $employee = Employee::factory()->create();
        $employee->updatePhoneExtension(new PhoneExtension($extension = 101));

        $this->assertEquals($extension, $employee->phone_extension);
    }

    public function testWithEmpty()
    {
        $employee = Employee::factory()->create();
        $employee->updatePhoneExtension(new PhoneExtension(null));

        $this->assertNull($employee->phone_extension);
    }
}
