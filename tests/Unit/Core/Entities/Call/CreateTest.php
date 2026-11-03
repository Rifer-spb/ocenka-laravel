<?php

namespace Tests\Unit\Core\Entities\Call;

use App\Core\Entities\Call\Call;
use App\Core\Entities\Call\MangoCallId;
use App\Core\Entities\User\Legal\Legal;
use App\Core\ValueObjects\NationalPhone;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Call::class, 'createNew')]
class CreateTest extends TestCase
{
    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $legal = Legal::factory()->create();

        $call = Call::createNew(
            $legal,
            new MangoCallId($mangoId = Str::random(40)),
            new NationalPhone($fromCall = 79112223344),
            new NationalPhone($toCall = 79223334455),
            $appearedAt = now()->toImmutable()->startOfSecond()
        );
        $call->refresh();

        $this->assertEquals($legal->id, $call->legal_id);
        $this->assertEquals($mangoId, $call->mango_call_id);
        $this->assertEquals($fromCall, $call->phone_from);
        $this->assertEquals($toCall, $call->phone_to);
        $this->assertEquals($appearedAt, $call->appeared_at);
        $this->assertTrue($call->isMissed());
    }
}
