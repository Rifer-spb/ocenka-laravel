<?php

namespace Tests\Unit\Core\Entities\Call\CommentTemplate;

use App\Core\Entities\Call\CommentTemplate\Name;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(Name::class)]
class NameTest extends TestCase
{
    public function testEmpty()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Пустое имя.');

        new Name('');
    }

    public function testSuccess()
    {
        $name = new Name($value = 'name');

        $this->assertEquals($value, $name->getValue());
    }
}
