<?php

namespace Tests\Unit\Core\Entities\User\Legal;

use App\Core\Entities\LegalType;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Legal\ValueObjects\Company;
use Carbon\Exceptions\InvalidFormatException;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Legal::class, 'updateCompany')]
class UpdateCompanyTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testInvalidDateOgrn()
    {
        $legal = Legal::factory()->withProfile()->create();
        $type = LegalType::factory()->create();

        $this->expectException(InvalidFormatException::class);

        $legal->updateCompany(
            $type,
            new Company(
                'fullName',
                'shortName',
                'abbr',
                'address',
                'invalid-date',
                1234567890,
                1234567890,
                1234567890,
            )
        );
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $legal = Legal::factory()->withProfile()->create();
        $type = LegalType::factory()->create();

        $legal->updateCompany(
            $type,
            new Company(
                $fullName = 'fullName',
                $shortName = 'shortName',
                $abbr = 'abbr',
                $address = 'address',
                $dateOgrn = '2026-01-01',
                $inn = 1234567890,
                $kpp = 1234567890,
                $ogrn = 1234567890,
            )
        );

        $legal->refresh();

        $this->assertEquals($fullName, $legal->profile->full_name);
        $this->assertEquals($shortName, $legal->profile->short_name);
        $this->assertEquals($abbr, $legal->profile->abbr);
        $this->assertEquals($address, $legal->profile->address);
        $this->assertEquals($dateOgrn, $legal->profile->date_ogrn->toDateString());
        $this->assertEquals($inn, $legal->profile->inn);
        $this->assertEquals($kpp, $legal->profile->kpp);
        $this->assertEquals($ogrn, $legal->profile->ogrn);
    }
}
