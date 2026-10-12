<?php

namespace App\Core\Entities\User\Legal\ValueObjects;

use App\Core\Attributes\TestClass;
use Tests\Unit\Core\Entities\User\Legal\ValueObjects\CompanyTest;

#[TestClass(CompanyTest::class)]
readonly class Company
{
    public ?string $fullName;
    public ?string $shortName;
    public ?string $abbr;
    public ?string $address;
    public ?string $dateOgrn;
    public ?int $inn;
    public ?int $kpp;
    public ?int $ogrn;

    public function __construct(
        ?string $fullName,
        ?string $shortName,
        ?string $abbr,
        ?string $address,
        ?string $dateOgrn,
        ?int $inn,
        ?int $kpp,
        ?int $ogrn,
    ) {
        $fullName = trim($fullName);
        $shortName = trim($shortName);
        $abbr = trim($abbr);
        $address = trim($address);
        $dateOgrn = trim($dateOgrn);

        $this->fullName = empty($fullName) ? null : $fullName;
        $this->shortName = empty($shortName) ? null : $shortName;
        $this->abbr = empty($abbr) ? null : $abbr;
        $this->address = empty($address) ? null : $address;
        $this->dateOgrn = empty($dateOgrn) ? null : $dateOgrn;

        if ($inn !== null && $inn <= 0) {
            throw new \DomainException('Некорректный ИНН.');
        }

        if ($kpp !== null && $kpp <= 0) {
            throw new \DomainException('Некорректный КПП.');
        }

        if ($ogrn !== null && $ogrn <= 0) {
            throw new \DomainException('Некорректный ОГРН.');
        }

        $this->inn = $inn;
        $this->kpp = $kpp;
        $this->ogrn = $ogrn;
    }
}
