<?php

namespace Tests\Integration\Core\Services\Mango;

use App\Core\Entities\Call\Call;
use App\Core\Entities\Call\MangoCallId;
use App\Core\Entities\Employee\Employee;
use App\Core\Entities\Employee\PhoneExtension;
use App\Core\Events\WebSocket\EventType;
use App\Core\Events\WebSocket\UserEvent;
use App\Core\Services\Mango\MangoService;
use App\Core\Services\Mango\WebSocketAction;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcherContract;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(MangoService::class, 'connected')]
class ConnectedTest extends TestCase
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

        $this->service->connected(
            new MangoCallId(Str::random(40)),
            new PhoneExtension(101),
            now()->toImmutable(),
        );
    }

    /**
     * @throws \Throwable
     */
    public function testEmployeeNotFound()
    {
        Call::factory()->create([
            'mango_call_id' => $mangoId = Str::random(40),
        ]);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Сотрудник не найден.');

        $this->service->connected(
            new MangoCallId($mangoId),
            new PhoneExtension(101),
            now()->toImmutable(),
        );
    }

    /**
     * @throws \Throwable
     */
    public function testEmployeeCallAccess()
    {
        Call::factory()->create([
            'mango_call_id' => $mangoId = Str::random(40),
        ]);
        Employee::factory()->create(['phone_extension' => $phoneExtension = 101]);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('У сотрудника нету прав на принятие звонка.');

        $this->service->connected(
            new MangoCallId($mangoId),
            new PhoneExtension($phoneExtension),
            now()->toImmutable(),
        );
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $call = Call::factory()->create();
        $employee = Employee::factory()->create([
            'legal_id' => $call->legal_id,
            'phone_extension' => 101,
            'can_call' => true
        ]);
        Employee::factory()->create([
            'legal_id' => $call->legal_id,
            'can_call' => true
        ]);
        $connectedBy = now()->toImmutable()->startOfSecond();

        $captured = null;
        $dispatcher = \Mockery::mock(BusDispatcherContract::class);
        $dispatcher->shouldReceive('dispatchNow')
            ->twice()
            ->andReturnUsing(function ($job) use (&$captured) {
                if ($job instanceof BroadcastEvent) {
                    $captured[] = $job->event;
                }
            });

        $this->app->instance(BusDispatcherContract::class, $dispatcher);

        $this->service->connected(
            new MangoCallId($call->mango_call_id),
            new PhoneExtension($employee->phone_extension),
            $connectedBy
        );

        $call->refresh();

        $this->assertEquals($employee->phys_id, $call->phys_id);
        $this->assertEquals($connectedBy, $call->connected_at);
        $this->assertTrue($call->isInProcess());

        $deleteEvent = $captured[0];
        $this->assertInstanceOf(UserEvent::class, $deleteEvent);
        $this->assertEquals(EventType::Call, $deleteEvent->type);
        $this->assertEquals(WebSocketAction::delete, $deleteEvent->data['action']);
        $this->assertEquals($call->id, $deleteEvent->data['callId']);

        $updateEvent = $captured[1];
        $this->assertInstanceOf(UserEvent::class, $updateEvent);
        $this->assertEquals(EventType::Call, $updateEvent->type);
        $this->assertEquals(WebSocketAction::update, $updateEvent->data['action']);
        $this->assertEquals($call->id, $updateEvent->data['callId']);
    }
}
