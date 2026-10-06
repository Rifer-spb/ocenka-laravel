<?php

namespace Integration\Manager\UseCases\Phys\Invite;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\Invite\InviteStatus;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use App\Core\ValueObjects\Email;
use App\Manager\UseCases\Phys\Invite\CreateUseCase;
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
        $phys = Phys::factory()->create();
        $legalEmail = 'legal@email.ru';

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("Юр.лицо с username {$legalEmail} не найдено.");

        $this->useCase->execute($phys, new Email($legalEmail));
    }

    public function testSuccess()
    {
        $phys = Phys::factory()->create();
        $legal = Legal::factory()->create();

        $this->useCase->execute($phys, new Email($legal->email));

        $this->assertDatabaseHas(Invite::getTableName(), [
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'status' => InviteStatus::WAIT->value,
            'for' => InviteForWho::LEGAL->value,
        ]);
    }
}
