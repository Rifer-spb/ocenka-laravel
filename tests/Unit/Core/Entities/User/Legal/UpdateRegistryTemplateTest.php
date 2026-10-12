<?php

namespace Tests\Unit\Core\Entities\User\Legal;

use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Legal\LegalProfile;
use App\Core\Entities\User\Legal\ValueObjects\RegistryTemplate;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Legal::class, 'updateRegistryTemplate')]
class UpdateRegistryTemplateTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $legal = Legal::factory()->withProfile()->create();
        $legal->updateRegistryTemplate(new RegistryTemplate($template = 'template'));

        $this->assertEquals($template, $legal->profile->registry_template);
        $this->assertDatabaseHas(LegalProfile::getTableName(), [
            'id' => $legal->id,
            'registry_template' => $template,
        ]);
    }
}
