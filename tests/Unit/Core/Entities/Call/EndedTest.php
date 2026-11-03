<?php

namespace Tests\Unit\Core\Entities\Call;

use App\Core\Entities\Call\Call;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Call::class,'ended')]
class EndedTest extends TestCase
{
    public function testInvalidStatus()
    {
        $endedAt = now()->toImmutable();

        $call = Call::factory()->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Звонок не был поднят.');

        $call->ended($endedAt);
    }

    public function testInvalidDate()
    {
        $endedAt = now()->toImmutable()->subMinutes(5);

        $call = Call::factory()->create([
            'connected_at' => now()->toImmutable(),
            'status' => Call::STATUS_IN_PROCESS
        ]);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Дата завершения звонка не может быть раньше даты начала звонка.');

        $call->ended($endedAt);
    }

    public function testSuccessWithNotCheck()
    {
        $endedAt = now()->toImmutable()->addMinutes(5)->startOfSecond();

        $call = Call::factory()->create([
            'status' => Call::STATUS_IN_PROCESS,
            'connected_at' => now()->toImmutable()->startOfSecond(),
        ]);
        $call->ended($endedAt);

        $this->assertEquals($endedAt, $call->ended_at);
        $this->assertEquals(Call::STATUS_NOT_CHECK_COMPLETED, $call->status);
        $this->assertNotEmpty($call->talk_time);
        $this->assertStringContainsString(':', $call->talk_time);
        $this->assertEmpty($call->comment);
    }

    public function testSuccessWithCheck()
    {
        $endedAt = now()->toImmutable()->addMinutes(5)->startOfSecond();

        $call = Call::factory()->create([
            'status' => Call::STATUS_IN_PROCESS,
            'comment' => 'comment',
            'connected_at' => now()->toImmutable()->startOfSecond(),
        ]);
        $call->ended($endedAt);

        $this->assertEquals($endedAt, $call->ended_at);
        $this->assertEquals(Call::STATUS_CHECKED_COMPLETED, $call->status);
        $this->assertNotEmpty($call->talk_time);
        $this->assertStringContainsString(':', $call->talk_time);
        $this->assertNotEmpty($call->comment);
    }
}
