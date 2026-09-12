<?php

namespace App\Core\Validators;

class ResourceValidator
{
    public static function isResource(string $resource): bool
    {
        return filter_var($resource, FILTER_VALIDATE_URL);
    }
}
