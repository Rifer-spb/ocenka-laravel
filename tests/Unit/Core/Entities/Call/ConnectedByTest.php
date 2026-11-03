<?php

namespace Tests\Unit\Core\Entities\Call;

use App\Core\Entities\Call\Call;
use App\Core\Entities\Employee\Employee;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Call::class,'connectedBy')]
class ConnectedByTest extends TestCase
{
    public function testInvalidStatus()
    {
        $employee = Employee::factory()->create();
        $connectedAt = now()->toImmutable();

        $call = Call::factory()->create(['status' => Call::STATUS_IN_PROCESS]);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Звонок должен быть в статусе входящего.');

        $call->connectedBy($employee, $connectedAt);
    }

    public function testInvalidDate()
    {
        $employee = Employee::factory()->create();
        $connectedAt = now()->toImmutable()->subMinutes(5);

        $call = Call::factory()->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Дата начала разговора не может быть раньше даты звонка.');

        $call->connectedBy($employee, $connectedAt);
    }

    public function testSuccess()
    {
        $employee = Employee::factory()->create();
        $connectedAt = now()->toImmutable()->startOfSecond();

        $call = Call::factory()->create();
        $call->connectedBy($employee, $connectedAt);

        $this->assertEquals($employee->phys_id, $call->phys_id);
        $this->assertEquals($connectedAt, $call->connected_at);
        $this->assertTrue($call->isInProcess());
    }
}
