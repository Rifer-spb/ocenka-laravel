<?php

namespace App\Core\Helpers;

class StringHelper
{
    public static function onlyNumbers(string $string): string
    {
        return preg_replace('/[^0-9]/', '', $string);
    }
}
