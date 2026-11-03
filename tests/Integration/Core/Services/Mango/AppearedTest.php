<?php

namespace Tests\Integration\Core\Services\Mango;

use App\Core\Entities\Call\Call;
use App\Core\Entities\Call\MangoCallId;
use App\Core\Entities\Employee\Employee;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Events\WebSocket\EventType;
use App\Core\Events\WebSocket\UserEvent;
use App\Core\Services\Mango\MangoService;
use App\Core\Services\Mango\WebSocketAction;
use App\Core\ValueObjects\NationalPhone;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Support\Str;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcherContract;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(MangoService::class, 'appeared')]
class AppearedTest extends TestCase
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
    public function testAlReadyExists()
    {
        Call::factory()->create(['mango_call_id' => $mangoId = Str::random(40)]);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Звонок уже добавлен.');

        $this->service->appeared(
            new MangoCallId($mangoId),
            new NationalPhone(79112223344),
            new NationalPhone(78122223344),
            now()->toImmutable(),
        );
    }

    /**
     * @throws \Throwable
     */
    public function testSamePhones()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Номера не могут быть одинаковые.');

        $this->service->appeared(
            new MangoCallId(Str::random(40)),
            new NationalPhone(79112223344),
            new NationalPhone(79112223344),
            now()->toImmutable(),
        );
    }

    /**
     * @throws \Throwable
     */
    public function testInvalidLegalId()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Юр.лицо не найдено.');

        $this->service->appeared(
            new MangoCallId(Str::random(40)),
            new NationalPhone(79112223344),
            new NationalPhone(78122223344),
            now()->toImmutable(),
        );
    }

    /**
     * @throws \Throwable
     */
    public function testEmployeesNotFound()
    {
        Legal::factory()
            ->withPhone(['phone' => $phoneTo = 78122223344])
            ->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Сотрудники не найдены.');

        $this->service->appeared(
            new MangoCallId(Str::random(40)),
            new NationalPhone(79112223344),
            new NationalPhone($phoneTo),
            now()->toImmutable(),
        );
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $phoneTo = 78122223344;

        $legal = Legal::factory()
            ->withPhone(['phone' => $phoneTo])
            ->create();
        Employee::factory()->create([
            'legal_id' => $legal->id,
            'can_call' => true
        ]);

        $captured = null;
        $dispatcher = \Mockery::mock(BusDispatcherContract::class);
        $dispatcher->shouldReceive('dispatchNow')
            ->once()
            ->andReturnUsing(function ($job) use (&$captured) {
                if ($job instanceof BroadcastEvent) {
                    $captured = $job->event;
                }
            });

        $this->app->instance(BusDispatcherContract::class, $dispatcher);

        $this->service->appeared(
            new MangoCallId($mangoId = Str::random(40)),
            new NationalPhone($phoneFrom = 79112223344),
            new NationalPhone($phoneTo),
            $appearedAt = now()->toImmutable()->startOfSecond(),
        );

        $this->assertDatabaseCount(Call::getTableName(), 1);

        $call = Call::orderByDesc('id')->firstOrFail();

        $this->assertEquals($mangoId, $call->mango_call_id);
        $this->assertEquals($phoneFrom, $call->phone_from);
        $this->assertEquals($phoneTo, $call->phone_to);
        $this->assertEquals($appearedAt, $call->appeared_at);

        $this->assertInstanceOf(UserEvent::class, $captured);
        $this->assertEquals(EventType::Call, $captured->type);
        $this->assertEquals(WebSocketAction::add, $captured->data['action']);
        $this->assertEquals($call->id, $captured->data['callId']);
    }
}
