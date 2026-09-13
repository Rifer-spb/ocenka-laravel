<?php

namespace App\Core\Validators;

class RequestValidator
{
    public static function isResponseCode(string $url, int $code): bool
    {
        $requestHeader = @get_headers($url);

        if ($requestHeader === false) {
            return false;
        }

        $responseCode = null;
        foreach ($requestHeader as $headerItem) {
            if(str_contains($headerItem, 'HTTP/')) {
                $responseCode = substr($headerItem, 9, 3);
            }
        }

        return $responseCode == $code;
    }
}
