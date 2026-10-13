<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Profile;

use App\Core\Entities\User\Legal\Legal;
use App\Manager\Http\Controllers\Legal\ProfileController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(ProfileController::class,'updateRegistryTemplate')]
class UpdateRegistryTemplateTest extends TestCase
{
    public function testRequired()
    {
        $legal = Legal::factory()->create();
        $route = $this->getRoute();

        $response = $this->actingAs($legal)->patch($route);

        $response->assertSessionHasErrors([
            'template' => 'Поле обязательно к заполнению',
        ]);
    }

    public function testSuccess()
    {
        $legal = Legal::factory()->withProfile()->create();
        $route = $this->getRoute();

        $response = $this->actingAs($legal)->patch($route, [
            'template' => $template = 'template',
        ]);

        $response->assertSessionHas(['success' => 'Успешно обновлено']);

        $legal->refresh();
        $this->assertEquals($template, $legal->profile->registry_template);
    }

    private function getRoute(): string
    {
        return route('manager.legal.profile.updateRegistryTemplate');
    }
}
