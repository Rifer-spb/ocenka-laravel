<?php

namespace App\Core\Infrastructure;

use Illuminate\Support\Str;

class CsvFile
{
    public const EXTENSION = 'csv';

    private string $path;

    public function __construct(string $path)
    {
        if (! is_file($path)) {
            throw new \RuntimeException("Файл {$path} не найден.");
        }

        FileValidator::validateExtension($path, self::EXTENSION);

        $this->path = $path;
    }

    public static function create(array $rows, ?array $labels = null, ?string $filepath = null): self
    {
        $rows = $labels ? array_merge([$labels], $rows) : $rows;

        if(! $filepath) {
            $filename = Str::ulid() . '.' . self::EXTENSION;
            $filepath = FolderPath::getTemp($filename);
        }

        CsvWriter::write($filepath, $rows);

        return new self($filepath);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSize(): int
    {
        $size = @filesize($this->path);

        if ($size === false) {
            throw new \RuntimeException("Не удалось получить размер файла {$this->path}.");
        }

        return $size;
    }

    public function delete(): bool
    {
        return unlink($this->path);
    }
}
