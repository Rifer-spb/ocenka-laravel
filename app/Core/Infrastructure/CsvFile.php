<?php

namespace App\Core\Infrastructure;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CsvFile
{
    private string $path;

    public function __construct(string $path)
    {
        if (!is_file($path)) {
            throw new \RuntimeException("Csv файл {$path} не найден.");
        }
        if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) !== 'csv') {
            throw new \InvalidArgumentException("Файл {$path} не является CSV.");
        }

        $this->path = $path;
    }

    public static function create(array $rows, ?array $labels = null, ?string $filepath = null): self
    {
        $rows = $labels ? array_merge([$labels], $rows) : $rows;

        if ($filepath !== null) {
            $filepath = basename(str_replace('\\', '/', $filepath));
            if ($filepath === '' || $filepath === '.' || $filepath === '..') {
                throw new \InvalidArgumentException("Недопустимое имя файла.");
            }
            if (!preg_match('/\.csv$/i', $filepath)) {
                $filepath = rtrim($filepath, '.') . '.csv';
            }
        } else {
            $filepath = FolderPath::getTemp((string) Str::ulid() . '.csv');
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
        return filesize($this->path);
    }

    public function delete(): bool
    {
        return unlink($this->path);
    }

    public function toResponse(string $downloadName): BinaryFileResponse
    {
        return response()->download($this->path, $downloadName)->deleteFileAfterSend();
    }
}
