<?php

namespace App\Core\Helpers;

class StringHelper
{
    public static function onlyNumbers(?string $string): string
    {
        return preg_replace('/[^0-9]/', '', trim($string));
    }

    public static function replaceQuotes(string $text): string
    {
        $text = trim($text);
        $text = htmlspecialchars_decode($text, ENT_QUOTES);
        $text = str_replace(['«', '»'], '"', $text);

        return preg_replace_callback(
            '/(([\"]{2,})|(?![^\W])(\"))|([^\s][\"]+(?![\w]))/u',
            function ($matches) {
                if (count($matches) === 3) {
                    return '«»';
                }

                if (!empty($matches[1])) {
                    return str_replace('"', '«', $matches[1]);
                }

                return str_replace('"', '»', $matches[4]);
            },
            $text
        );
    }
}
