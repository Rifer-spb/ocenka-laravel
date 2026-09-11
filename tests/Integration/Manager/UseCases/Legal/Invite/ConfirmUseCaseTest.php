<?php

namespace Integration\Manager\UseCases\Legal\Invite;

use App\Core\Models\EntityNotFoundException;
use App\Core\Models\Invite\Invite;
use App\Manager\UseCases\Legal\Invite\ConfirmUseCase;
use Tests\TestCase;

class ConfirmUseCaseTest extends TestCase
{
    private ConfirmUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app(ConfirmUseCase::class);
    }

    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withActive()->create();

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Отправленная заявка не найдена.');

        $this->useCase->execute($invite->legal, $invite->id);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withWait()->create();
        $this->useCase->execute($invite->legal, $invite->id);
        $invite->refresh();

        $this->assertTrue($invite->isActive());
    }
}
