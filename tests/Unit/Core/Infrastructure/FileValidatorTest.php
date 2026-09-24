<?php

namespace Tests\Unit\Core\Infrastructure;

use App\Core\Infrastructure\FileValidator;
use Tests\TestCase;

class FileValidatorTest extends TestCase
{
    public function testSuccess(): void
    {
        $this->expectNotToPerformAssertions();

        FileValidator::validateExtension('report.csv', 'csv');
    }

    public function testCaseInsensitive(): void
    {
        $this->expectNotToPerformAssertions();

        FileValidator::validateExtension('REPORT.CSV', 'csv');
        FileValidator::validateExtension('report.csv', 'CSV');
    }

    public function testFullPathWithDots(): void
    {
        $this->expectNotToPerformAssertions();

        FileValidator::validateExtension('/var/www/storage/tmp/report.csv', 'csv');
        FileValidator::validateExtension('report.2024.01.csv', 'csv');
    }

    public function testOtherExtension(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Файл report.txt не является csv.');

        FileValidator::validateExtension('report.txt', 'csv');
    }

    public function testNoExtension(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        FileValidator::validateExtension('report', 'csv');
    }

    public function testTrailingDot(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        FileValidator::validateExtension('report.', 'csv');
    }

    public function testEmptyPath(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        FileValidator::validateExtension('', 'csv');
    }

    public function testExtensionInTheMiddle(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        FileValidator::validateExtension('report.csv.txt', 'csv');
    }

    public function testLongerExtension(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        FileValidator::validateExtension('report.csvx', 'csv');
    }

    public function testExtensionOnlyInDirectory(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        FileValidator::validateExtension('/tmp/file.csv/report', 'csv');
    }
}
