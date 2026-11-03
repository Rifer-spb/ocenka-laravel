<?php

namespace Tests\Unit\Core\Entities\Call;

use App\Core\Entities\Call\Call;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Call::class, 'isMissed')]
#[CoversMethod(Call::class, 'isCompleted')]
#[CoversMethod(Call::class, 'isInProcess')]
class StatusTest extends TestCase
{
    public function testTrueIsMissed()
    {
        $call = Call::factory()->create();

        $this->assertTrue($call->isMissed());
    }

    public function testFalseIsMissed()
    {
        $call = Call::factory()->create(['status' => Call::STATUS_IN_PROCESS]);

        $this->assertFalse($call->isMissed());
    }

    public function testTrueIsNotCheckCompleted()
    {
        $call = Call::factory()->create(['status' => Call::STATUS_NOT_CHECK_COMPLETED]);

        $this->assertTrue($call->isCompleted());
    }

    public function testTrueIsCheckCompleted()
    {
        $call = Call::factory()->create(['status' => Call::STATUS_CHECKED_COMPLETED]);

        $this->assertTrue($call->isCompleted());
    }

    public function testFalseIsCompleted()
    {
        $call = Call::factory()->create(['status' => Call::STATUS_IN_PROCESS]);

        $this->assertFalse($call->isCompleted());
    }

    public function testTrueInProcess()
    {
        $call = Call::factory()->create(['status' => Call::STATUS_IN_PROCESS]);

        $this->assertTrue($call->isInProcess());
    }

    public function testFalseInProcess()
    {
        $call = Call::factory()->create();

        $this->assertFalse($call->isInProcess());
    }
}
