<?php

namespace Tests\Unit\Core\Entities\User\Legal;

use App\Core\Entities\User\Legal\Legal;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Legal::class, 'getName')]
class GetNameTest extends TestCase
{
    public function testSuccessWithEmptyProfileName()
    {
        $legal = Legal::factory()->withProfile()->create();

        $this->assertEquals($legal->getName(), $legal->username);
    }

    public function testSuccessWithProfileName()
    {
        $legal = Legal::factory()
            ->withProfile(['short_name' => 'new-name'])
            ->create();

        $this->assertEquals($legal->getName(), $legal->profile->short_name);
    }
}
