<?php

namespace Tests\Unit\Core\Models\Notary;

use App\Core\Models\Notary\NotariatId;
use App\Core\Models\Notary\Notary;
use App\Core\Models\Notary\NotaryRegion;
use App\Core\ValueObjects\NationalPhone;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess()
    {
        $region = NotaryRegion::findOrFail(1);

        $notary = Notary::createNew(
            new NotariatId($notariatId = 10),
            $region,
            $name = 'name',
            $address = 'address',
            [
                new NationalPhone($phone1 = 79123456789),
                new NationalPhone($phone2 = 79123456710),
            ],
        );
        $notary->refresh();

        $this->assertEquals($notariatId, $notary->notariat_notary_id);
        $this->assertEquals($name, $notary->name);
        $this->assertEquals($address, $notary->address);
        $this->assertCount(2, $notary->phones);

        $this->assertEquals($phone1, $notary->phones[0]->phone);
        $this->assertEquals($phone2, $notary->phones[1]->phone);
    }
}
