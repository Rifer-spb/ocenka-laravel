<?php

namespace Integration\Manager\UseCases\Legal\Invite;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\EntityNotFoundException;
use App\Core\Models\Invite\Invite;
use App\Manager\UseCases\Legal\Invite\UpdateDoReportUseCase;
use Tests\TestCase;

class UpdateDoReportUseCaseTest extends TestCase
{
    private UpdateDoReportUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app(UpdateDoReportUseCase::class);
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
        $access = $employee->reportAccess[0];

        $this->useCase->execute($invite->legal, $invite->id, $access->id);

        $employee->refresh();
        $access = $employee->getReportAccess($access->id);

        $this->assertTrue($access->do);
    }
}
