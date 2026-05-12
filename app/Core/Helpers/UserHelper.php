<?php

namespace App\Core\Helpers;

class UserHelper
{
    public static function getShortName(string $value): string
    {
        $names = explode(' ', $value);
        $string = $names[0];
        if (count($names) > 1) {
            unset($names[0]);
            $secondNames = [];
            foreach ($names as $name) {
                $secondNames[] = mb_substr($name, 0, 1, 'UTF-8');
            }
            $string .= ' '.implode('.', $secondNames);
        }

        return $string;
    }
}
