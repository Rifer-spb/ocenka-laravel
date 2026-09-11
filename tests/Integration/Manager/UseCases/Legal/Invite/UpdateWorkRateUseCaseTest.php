<?php

namespace Integration\Manager\UseCases\Legal\Invite;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\Invite\Invite;
use App\Exceptions\EntityNotFoundException;
use App\Manager\UseCases\Legal\Invite\UpdateWorkRateUseCase;
use Tests\TestCase;

class UpdateWorkRateUseCaseTest extends TestCase
{
    private UpdateWorkRateUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app(UpdateWorkRateUseCase::class);
    }

    public function testInvalidInviteStatus()
    {
        $invite = Invite::factory()->withEmployee()->withWait()->create();

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Отправленная заявка не найдена.');

        $this->useCase->execute($invite->legal, $invite->id, 1);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withActive()->withEmployee()->create();
        $employee = EmployeeFinder::getByInvite($invite);

        $this->useCase->execute($invite->legal, $invite->id, $value = 10);
        $employee->refresh();

        $this->assertEquals($value, $employee->work_rate);
    }
}
