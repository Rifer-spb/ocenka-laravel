<?php

namespace App\Core\Infrastructure;

class CsvWriter
{
    public static function write(string $path, array $rows, string $delimiter = ';'): CsvFile
    {
        if (! $rows) {
            throw new \RuntimeException('Не переданы строки для csv.');
        }

        $file = fopen($path, 'w');

        foreach ($rows as $fields) {
            foreach ($fields as $key => $field) {
                $fields[$key] = self::toCharset((string) ($field ?? ''));
            }
            fputcsv($file, $fields, $delimiter);
        }

        fclose($file);

        return new CsvFile($path);
    }

    private static function toCharset(string $value, string $from = 'UTF-8', string $to = 'Windows-1251'): string
    {
        $result = iconv("{$from}//IGNORE", "{$to}//IGNORE", $value);

        return $result === false ? '' : $result;
    }
}
