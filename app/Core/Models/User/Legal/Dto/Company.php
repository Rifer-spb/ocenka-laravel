<?php

namespace App\Core\Models\User\Legal\Dto;

readonly class Company
{
    public function __construct(
        public ?string $fullName,
        public ?string $shortName,
        public ?string $abbr,
        public ?string $address,
        public ?string $dateOgrn,
        public ?int $inn,
        public ?int $kpp,
        public ?int $ogrn
    ) {}
}
