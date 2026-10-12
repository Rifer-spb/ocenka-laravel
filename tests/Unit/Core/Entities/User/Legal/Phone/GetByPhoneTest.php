<?php

namespace Tests\Unit\Core\Entities\User\Legal\Phone;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\Legal\Legal;
use Tests\TestCase;

class GetByPhoneTest extends TestCase
{
    public function testInvalidId()
    {
        $legal = Legal::factory()->create();

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Номер телефона не найден.');

        $legal->getPhoneById(1);
    }
}
