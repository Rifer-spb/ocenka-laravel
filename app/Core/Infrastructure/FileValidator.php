<?php

namespace App\Core\Infrastructure;

class FileValidator
{
    /**
     * @param string $filepath
     * @param string $extension
     * @return void
     * @see \Tests\Unit\Core\Infrastructure\FileValidatorTest
     */
    public static function validateExtension(string $filepath, string $extension): void
    {
        if (strtolower(pathinfo($filepath, PATHINFO_EXTENSION)) !== strtolower($extension)) {
            throw new \InvalidArgumentException("Файл {$filepath} не является {$extension}.");
        }
    }
}
