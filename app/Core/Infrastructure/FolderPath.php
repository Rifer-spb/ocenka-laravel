<?php

namespace App\Core\Infrastructure;

use Illuminate\Support\Facades\Storage;

class FolderPath
{
    public static function getTemp(?string $subPath = null): string
    {
        return self::getPath('temp', $subPath);
    }

    private static function getPath(string $disk, ?string $subPath): string
    {
        return Storage::disk($disk)->path($subPath ?? '');
    }
}
