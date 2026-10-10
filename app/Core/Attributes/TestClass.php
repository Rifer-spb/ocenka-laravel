<?php

namespace App\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class TestClass
{
    public function __construct(
        public string $testClass,
    ) {}
}
