<?php

namespace Integration\Manager\UseCases\Legal\Invite;

use App\Core\Jobs\SendMailJob;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\Invite\Invite;
use App\Manager\UseCases\Legal\Invite\ResendUseCase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ResendUseCaseTest extends TestCase
{
    private ResendUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app(ResendUseCase::class);
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
        Queue::assertNothingPushed();

        $invite = Invite::factory()->withWait()->create();
        $this->useCase->execute($invite->legal, $invite->id);

        Queue::assertPushed(SendMailJob::class);
    }
}
