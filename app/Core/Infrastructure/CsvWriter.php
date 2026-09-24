<?php

namespace App\Core\Infrastructure;

class CsvWriter
{
    public static function write(string $path, array $rows, string $delimiter = ';'): void
    {
        FileValidator::validateExtension($path, 'csv');

        if (! $rows) {
            throw new \InvalidArgumentException('Не переданы строки для csv.');
        }

        $file = @fopen($path, 'w');

        if ($file === false) {
            throw new \RuntimeException("Не удалось открыть {$path} для записи.");
        }

        try {
            foreach ($rows as $fields) {
                foreach ($fields as $key => $field) {
                    $fields[$key] = self::toCharset((string) ($field ?? ''));
                }
                fputcsv($file, $fields, $delimiter);
            }
        } finally {
            fclose($file);
        }
    }

    private static function toCharset(string $value, string $from = 'UTF-8', string $to = 'Windows-1251'): string
    {
        $result = iconv("{$from}//IGNORE", "{$to}//IGNORE", $value);

        return $result === false ? '' : $result;
    }
}
