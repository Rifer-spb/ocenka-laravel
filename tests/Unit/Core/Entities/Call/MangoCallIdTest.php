<?php

namespace Tests\Unit\Core\Entities\Call;

use App\Core\Attributes\TestClass;
use App\Core\Entities\Call\MangoCallId;
use Tests\TestCase;

#[TestClass(MangoCallId::class)]
class MangoCallIdTest extends TestCase
{
    public function testCreatesWithValidValue(): void
    {
        $id = new MangoCallId('abc-123');

        $this->assertSame('abc-123', $id->getValue());
    }

    public function testThrowsWhenValueIsEmpty(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Идентификатор звонка не передан.');

        new MangoCallId('');
    }

    public function testThrowsWhenValueIsZeroString(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Идентификатор звонка не передан.');

        new MangoCallId('0');
    }

    public function testAllowsWhitespaceValue(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Идентификатор звонка не передан.');

        new MangoCallId(' ');
    }

    public function testAllowsNumericString(): void
    {
        $id = new MangoCallId('12345');

        $this->assertSame('12345', $id->getValue());
    }

    public function testAllowsLongValue(): void
    {
        $value = str_repeat('a', 1000);

        $id = new MangoCallId($value);

        $this->assertSame($value, $id->getValue());
    }

    public function testPreservesExactValue(): void
    {
        $value = 'Call-ID/abc_123-xyz';

        $id = new MangoCallId("  $value   ");

        $this->assertSame($value, $id->getValue());
    }
}
