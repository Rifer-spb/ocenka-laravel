<?php

namespace Tests\Unit\Core\Entities\Call\CommentTemplate;

use App\Core\Entities\Call\CommentTemplate\Text;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(Text::class)]
class TextTest extends TestCase
{
    public function testEmpty()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Пустой текст шаблона.');

        new Text('');
    }

    public function testSuccess()
    {
        $name = new Text($value = 'text');

        $this->assertEquals($value, $name->getValue());
    }
}
