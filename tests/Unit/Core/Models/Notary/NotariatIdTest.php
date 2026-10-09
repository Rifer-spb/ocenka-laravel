<?php

namespace Tests\Unit\Core\Models\Notary;

use App\Core\Entities\Notary\NotariatId;
use Tests\TestCase;

class NotariatIdTest extends TestCase
{
    public function testSuccessWithInt(): void
    {
        $id = new NotariatId(42);

        $this->assertEquals(42, $id->getValue());
    }

    public function testInvalidWithZero(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Значение notariatId не может быть 0 или отрицательным.');

        new NotariatId(0);
    }

    public function testInvalidWithNegative(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Значение notariatId не может быть 0 или отрицательным.');

        new NotariatId(-5);
    }
}
