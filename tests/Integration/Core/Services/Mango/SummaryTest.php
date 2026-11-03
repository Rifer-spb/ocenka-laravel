<?php

namespace Tests\Integration\Core\Services\Mango;

use App\Core\Entities\Call\Call;
use App\Core\Entities\Call\MangoCallId;
use App\Core\Entities\Employee\Employee;
use App\Core\Events\WebSocket\EventType;
use App\Core\Events\WebSocket\UserEvent;
use App\Core\Services\Mango\MangoCallStatus;
use App\Core\Services\Mango\MangoService;
use App\Core\Services\Mango\WebSocketAction;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcherContract;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(MangoService::class, 'summary')]
class SummaryTest extends TestCase
{
    private MangoService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(MangoService::class);
    }

    /**
     * @throws \Throwable
     */
    public function testCallNotFound()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Звонок не найден.');

        $this->service->summary(
            new MangoCallId(Str::random(40)),
            new MangoCallStatus(0),
            now()->toImmutable(),
        );
    }

    /**
     * @throws \Throwable
     */
    public function testInvalidCallMissedStatus()
    {
        $call = Call::factory()->create(['status' => Call::STATUS_IN_PROCESS]);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Звонок должен иметь статус пропущенный.');

        $this->service->summary(
            new MangoCallId($call->mango_call_id),
            new MangoCallStatus(0),
            now()->toImmutable(),
        );
    }

    /**
     * @throws \Throwable
     */
    public function testSuccessWithCallMissed()
    {
        $call = Call::factory()->create();
        Employee::factory()->create([
            'legal_id' => $call->legal_id,
            'can_call' => true
        ]);

        $deleteEvent = null;
        $dispatcher = \Mockery::mock(BusDispatcherContract::class);
        $dispatcher->shouldReceive('dispatchNow')
            ->once()
            ->andReturnUsing(function ($job) use (&$deleteEvent) {
                if ($job instanceof BroadcastEvent) {
                    $deleteEvent = $job->event;
                }
            });

        $this->app->instance(BusDispatcherContract::class, $dispatcher);

        $this->service->summary(
            new MangoCallId($call->mango_call_id),
            new MangoCallStatus(0),
            now()->toImmutable()->startOfSecond(),
        );

        $call->refresh();
        $this->assertTrue($call->isMissed());

        $this->assertInstanceOf(UserEvent::class, $deleteEvent);
        $this->assertEquals(EventType::Call, $deleteEvent->type);
        $this->assertEquals(WebSocketAction::delete, $deleteEvent->data['action']);
        $this->assertEquals($call->id, $deleteEvent->data['callId']);
    }

    /**
     * @throws \Throwable
     */
    public function testSuccessWithCallCompleted()
    {
        $employee = Employee::factory()->create();
        $call = Call::factory()->create([
            'phys_id' => $employee->phys_id,
            'status' => Call::STATUS_IN_PROCESS,
            'connected_at' => now()->toImmutable()->startOfSecond()
        ]);

        $deleteEvent = null;
        $dispatcher = \Mockery::mock(BusDispatcherContract::class);
        $dispatcher->shouldReceive('dispatchNow')
            ->once()
            ->andReturnUsing(function ($job) use (&$deleteEvent) {
                if ($job instanceof BroadcastEvent) {
                    $deleteEvent = $job->event;
                }
            });

        $this->app->instance(BusDispatcherContract::class, $dispatcher);

        $this->service->summary(
            new MangoCallId($call->mango_call_id),
            new MangoCallStatus(1),
            now()->toImmutable()->startOfSecond(),
        );

        $call->refresh();
        $this->assertTrue($call->isCompleted());

        $this->assertInstanceOf(UserEvent::class, $deleteEvent);
        $this->assertEquals(EventType::Call, $deleteEvent->type);
        $this->assertEquals(WebSocketAction::update, $deleteEvent->data['action']);
        $this->assertEquals($call->id, $deleteEvent->data['callId']);
    }
}
