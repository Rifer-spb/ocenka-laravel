<?php

namespace App\Core\Entities\Call\CommentTemplate;

use App\Core\Attributes\TestClass;
use Tests\Unit\Core\Entities\Call\CommentTemplate\NameTest;

#[TestClass(NameTest::class)]
class Name
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \DomainException('Пустое имя.');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
