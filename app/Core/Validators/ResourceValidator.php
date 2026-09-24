<?php

namespace App\Core\Validators;

class ResourceValidator
{
    /**
     * @param string $resource
     * @return bool
     * @see \Tests\Unit\Core\Validators\ResourceValidatorTest
     */
    public static function isResource(string $resource): bool
    {
        return filter_var($resource, FILTER_VALIDATE_URL);
    }
}
