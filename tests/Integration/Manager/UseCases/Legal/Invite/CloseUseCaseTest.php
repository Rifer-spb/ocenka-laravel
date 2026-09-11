<?php

namespace Integration\Manager\UseCases\Legal\Invite;

use App\Core\Models\EntityNotFoundException;
use App\Core\Models\Invite\Invite;
use App\Manager\UseCases\Legal\Invite\CloseUseCase;
use Tests\TestCase;

class CloseUseCaseTest extends TestCase
{
    private CloseUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app(CloseUseCase::class);
    }

    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withWait()->create();

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Отправленная заявка не найдена.');

        $this->useCase->execute($invite->legal, $invite->id);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withActive()->withEmployee()->create();
        $this->useCase->execute($invite->legal, $invite->id);
        $invite->refresh();

        $this->assertTrue($invite->isComplete());
    }
}
