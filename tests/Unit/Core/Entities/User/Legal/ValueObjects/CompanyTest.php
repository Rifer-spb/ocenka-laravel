<?php

namespace Tests\Unit\Core\Entities\User\Legal\ValueObjects;

use App\Core\Entities\User\Legal\ValueObjects\Company;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(Company::class)]
class CompanyTest extends TestCase
{
    public function testSuccess(): void
    {
        $company = new Company(
            fullName: 'ООО Ромашка',
            shortName: 'Ромашка',
            abbr: 'ООО',
            address: 'г. Москва, ул. Пушкина, д. 1',
            dateOgrn: '2020-01-01',
            inn: 1234567890,
            kpp: 123456789,
            ogrn: 1234567890123,
        );

        $this->assertSame('ООО Ромашка', $company->fullName);
        $this->assertSame('Ромашка', $company->shortName);
        $this->assertSame('ООО', $company->abbr);
        $this->assertSame('г. Москва, ул. Пушкина, д. 1', $company->address);
        $this->assertSame('2020-01-01', $company->dateOgrn);
        $this->assertSame(1234567890, $company->inn);
        $this->assertSame(123456789, $company->kpp);
        $this->assertSame(1234567890123, $company->ogrn);
    }

    public function testTrim(): void
    {
        $company = new Company(
            fullName: '  ООО Ромашка  ',
            shortName: "\tРомашка\n",
            abbr: '  ООО  ',
            address: '  г. Москва  ',
            dateOgrn: '  2020-01-01  ',
            inn: 1234567890,
            kpp: 123456789,
            ogrn: 1234567890123,
        );

        $this->assertSame('ООО Ромашка', $company->fullName);
        $this->assertSame('Ромашка', $company->shortName);
        $this->assertSame('ООО', $company->abbr);
        $this->assertSame('г. Москва', $company->address);
        $this->assertSame('2020-01-01', $company->dateOgrn);
    }

    public function testEmptyStrings(): void
    {
        $company = new Company(
            fullName: '',
            shortName: '',
            abbr: '',
            address: '',
            dateOgrn: '',
            inn: 1234567890,
            kpp: 123456789,
            ogrn: 1234567890123,
        );

        $this->assertNull($company->fullName);
        $this->assertNull($company->shortName);
        $this->assertNull($company->abbr);
        $this->assertNull($company->address);
        $this->assertNull($company->dateOgrn);
    }

    public function testWhitespaceOnly(): void
    {
        $company = new Company(
            fullName: '   ',
            shortName: "\t\t",
            abbr: "\n",
            address: '  ',
            dateOgrn: "\r\n",
            inn: 1234567890,
            kpp: 123456789,
            ogrn: 1234567890123,
        );

        $this->assertNull($company->fullName);
        $this->assertNull($company->shortName);
        $this->assertNull($company->abbr);
        $this->assertNull($company->address);
        $this->assertNull($company->dateOgrn);
    }

    public function testNullStringsStayNull(): void
    {
        $company = new Company(
            fullName: null,
            shortName: null,
            abbr: null,
            address: null,
            dateOgrn: null,
            inn: null,
            kpp: null,
            ogrn: null,
        );

        $this->assertNull($company->fullName);
        $this->assertNull($company->shortName);
        $this->assertNull($company->abbr);
        $this->assertNull($company->address);
        $this->assertNull($company->dateOgrn);
        $this->assertNull($company->inn);
        $this->assertNull($company->kpp);
        $this->assertNull($company->ogrn);
    }

    public function testNegativeInnThrows(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный ИНН.');

        new Company(
            fullName: null,
            shortName: null,
            abbr: null,
            address: null,
            dateOgrn: null,
            inn: -1,
            kpp: 123456789,
            ogrn: 1234567890123,
        );
    }

    public function testZeroInnThrows(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный ИНН.');

        new Company(
            fullName: null,
            shortName: null,
            abbr: null,
            address: null,
            dateOgrn: null,
            inn: 0,
            kpp: 123456789,
            ogrn: 1234567890123,
        );
    }

    public function testNegativeKppThrows(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный КПП.');

        new Company(
            fullName: null,
            shortName: null,
            abbr: null,
            address: null,
            dateOgrn: null,
            inn: 1234567890,
            kpp: -1,
            ogrn: 1234567890123,
        );
    }

    public function testZeroKppThrows(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный КПП.');

        new Company(
            fullName: null,
            shortName: null,
            abbr: null,
            address: null,
            dateOgrn: null,
            inn: 1234567890,
            kpp: 0,
            ogrn: 1234567890123,
        );
    }

    public function testNegativeOgrnThrows(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный ОГРН.');

        new Company(
            fullName: null,
            shortName: null,
            abbr: null,
            address: null,
            dateOgrn: null,
            inn: 1234567890,
            kpp: 123456789,
            ogrn: -1,
        );
    }

    public function testZeroOgrnThrows(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный ОГРН.');

        new Company(
            fullName: null,
            shortName: null,
            abbr: null,
            address: null,
            dateOgrn: null,
            inn: 1234567890,
            kpp: 123456789,
            ogrn: 0,
        );
    }
}
