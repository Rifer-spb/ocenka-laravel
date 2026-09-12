<?php

namespace App\Console\Commands\Notariat\ScanNotaries;

class RequestHeaderValidator
{
    public static function validate(string $parseUrl): bool
    {
        $requestHeader = @get_headers($parseUrl);

        if ($requestHeader === false) {
            return false;
        }

        $responseCode = null;
        foreach ($requestHeader as $headerItem) {
            if(str_contains($headerItem, 'HTTP/')) {
                $responseCode = substr($headerItem, 9, 3);
            }
        }

        return $responseCode == 200;
    }
}
