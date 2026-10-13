<?php

namespace Tests\Integration\Console\Commands\ScanNotaries;

use App\Console\Commands\Notariat\ScanNotaries\ScanNotariesCommand;
use App\Core\Entities\Notariat\Notariat;
use App\Core\Entities\Notary\Notary;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(ScanNotariesCommand::class)]
class ScanNotariesTest extends TestCase
{
    private const CANARY_ID = 1;

    public function testSuccess()
    {
        $notariat = Notariat::current();
        $notariat->current_notary_scan_id = self::CANARY_ID;
        $notariat->save();

        $this->artisan('notariat:scan')
            ->expectsOutputToContain('сохранён')
            ->assertSuccessful();

        $notary = Notary::where('notariat_notary_id', self::CANARY_ID)->firstOrFail();
        $phones = $notary->phones()->pluck('phone')->all();

        // имя и адрес: непустые, с буквами, и не одно и то же
        $this->assertMatchesRegularExpression('/\p{L}{3,}/u', $notary->name);
        $this->assertMatchesRegularExpression('/\p{L}{3,}/u', $notary->address);
        $this->assertNotEquals($notary->name, $notary->address);

        // телефоны: хотя бы один, каждый в формате 7XXXXXXXXXX
        $this->assertNotEmpty($phones);

        $addressDigits = preg_replace('/\D/', '', $notary->address);

        foreach ($phones as $phone) {
            $this->assertMatchesRegularExpression('/^7\d{10}$/', $phone);

            // номер телефона не должен оказаться внутри адреса
            $this->assertStringNotContainsString($phone, $addressDigits);
        }
    }
}
