<?php

namespace Integration\Manager\UseCases\Legal\Invite;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\EntityNotFoundException;
use App\Core\Models\Invite\Invite;
use App\Manager\UseCases\Legal\Invite\UpdateManagerUseCase;
use Tests\TestCase;

class UpdateManagerUseCaseTest extends TestCase
{
    private UpdateManagerUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app(UpdateManagerUseCase::class);
    }

    public function testInvalidInviteStatus()
    {
        $invite = Invite::factory()->withEmployee()->withWait()->create();

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Отправленная заявка не найдена.');

        $this->useCase->execute($invite->legal, $invite->id);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withActive()->withEmployee()->create();
        $employee = EmployeeFinder::getByInvite($invite);

        $this->useCase->execute($invite->legal, $invite->id);
        $employee->refresh();

        $this->assertTrue($employee->is_manager);
    }
}
