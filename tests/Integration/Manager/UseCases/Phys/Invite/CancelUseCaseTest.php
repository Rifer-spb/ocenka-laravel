<?php

namespace Integration\Manager\UseCases\Phys\Invite;

use App\Core\Models\EntityNotFoundException;
use App\Core\Models\Invite\Invite;
use App\Manager\UseCases\Phys\Invite\CancelUseCase;
use Tests\TestCase;

class CancelUseCaseTest extends TestCase
{
    private CancelUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app(CancelUseCase::class);
    }

    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withActive()->create();

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Отправленная заявка не найдена.');

        $this->useCase->execute($invite->phys, $invite->id);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withWait()->create();
        $this->useCase->execute($invite->phys, $invite->id);

        $this->assertDatabaseMissing(Invite::getTableName(), [
            'id' => $invite->id
        ]);
    }
}
