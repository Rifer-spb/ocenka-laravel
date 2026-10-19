<?php

namespace App\Core\Entities\Call\CommentTemplate;

use App\Core\Attributes\TestClass;
use Tests\Unit\Core\Entities\Call\CommentTemplate\TextTest;

#[TestClass(TextTest::class)]
class Text
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \DomainException('Пустой текст шаблона.');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
