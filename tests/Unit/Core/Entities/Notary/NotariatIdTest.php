<?php

namespace Tests\Unit\Core\Entities\Notary;

use App\Core\Entities\Notary\NotariatId;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(NotariatId::class)]
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
