<?php

namespace Integration\Manager\UseCases\Legal\Invite;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\Invite\InviteStatus;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use App\Core\ValueObjects\Email;
use App\Manager\UseCases\Legal\Invite\CreateUseCase;
use Tests\TestCase;

class CreateUseCaseTest extends TestCase
{
    private CreateUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app(CreateUseCase::class);
    }

    public function testInvalidStatus()
    {
        $legal = Legal::factory()->create();
        $physEmail = 'phys@email.ru';

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("Физ.лицо с username {$physEmail} не найдено.");

        $this->useCase->execute($legal, new Email($physEmail));
    }

    public function testSuccess()
    {
        $legal = Legal::factory()->create();
        $phys = Phys::factory()->create();

        $this->useCase->execute($legal, new Email($phys->email));

        $this->assertDatabaseHas(Invite::getTableName(), [
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'status' => InviteStatus::WAIT->value,
            'for' => InviteForWho::PHYS->value,
        ]);
    }
}
