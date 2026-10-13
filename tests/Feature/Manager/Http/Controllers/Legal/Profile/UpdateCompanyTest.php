<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Profile;

use App\Core\Entities\LegalType;
use App\Core\Entities\User\Legal\Legal;
use App\Manager\Http\Controllers\Legal\ProfileController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(ProfileController::class,'updateCompany')]
class UpdateCompanyTest extends TestCase
{
    public function testRequired()
    {
        $legal = Legal::factory()->create();
        $route = $this->getRoute();

        $response = $this->actingAs($legal)->patch($route);

        $response->assertSessionHasErrors([
            'typeId' => 'Поле обязательно для заполнения',
            'fullName' => 'Поле обязательно для заполнения',
            'shortName' => 'Поле обязательно для заполнения',
            'abbr' => 'Поле обязательно для заполнения',
            'address' => 'Поле обязательно для заполнения',
            'dateOgrn' => 'Поле обязательно для заполнения',
            'inn' => 'Поле обязательно для заполнения',
            'kpp' => 'Поле обязательно для заполнения',
            'ogrn' => 'Поле обязательно для заполнения',
        ]);
    }

    public function testTypeIdMustExist()
    {
        $legal = Legal::factory()->create();
        $route = $this->getRoute();

        $response = $this->actingAs($legal)->patch($route, [
            'typeId' => 99999
        ]);

        $response->assertSessionHasErrors(['typeId']);
    }

    public function testTypeIdMustBeInteger()
    {
        $legal = Legal::factory()->create();
        $route = $this->getRoute();

        $response = $this->actingAs($legal)->patch($route, [
            'typeId' => 'not-a-number',
        ]);

        $response->assertSessionHasErrors(['typeId']);
    }

    public function testDateOgrnMustBeDate()
    {
        $legal = Legal::factory()->create();
        $route = $this->getRoute();
        $data = $this->validData(['dateOgrn' => 'not-a-date']);

        $response = $this->actingAs($legal)->patch($route, $data);

        $response->assertSessionHasErrors(['dateOgrn']);
    }

    public function testFullNameMaxLength()
    {
        $legal = Legal::factory()->create();
        $route = $this->getRoute();
        $data = $this->validData(['fullName' => str_repeat('a', 256)]);

        $response = $this->actingAs($legal)->patch($route, $data);

        $response->assertSessionHasErrors(['fullName']);
    }

    public function testSuccess()
    {
        $legal = Legal::factory()->withProfile()->create();
        $type = LegalType::factory()->create();
        $route = $this->getRoute();
        $data = $this->validData(['typeId' => $type->id]);

        $response = $this->actingAs($legal)->patch($route, $data);

        $response->assertSessionHas(['success' => 'Успешно обновлено']);

        $legal->refresh();
        $this->assertEquals($type->id, $legal->profile->type_id);
        $this->assertEquals('ООО Ромашка', $legal->profile->full_name);
    }

    private function getRoute(): string
    {
        return route('manager.legal.profile.company.update');
    }

    private function validData(array $override = []): array
    {
        return array_merge([
            'typeId' => LegalType::factory()->create()->id,
            'fullName' => 'ООО Ромашка',
            'shortName' => 'Ромашка',
            'abbr' => 'ООО',
            'address' => 'г. Москва, ул. Пушкина, д. 1',
            'dateOgrn' => '2020-01-01',
            'inn' => 1234567890,
            'kpp' => 123456789,
            'ogrn' => 1234567890123,
        ], $override);
    }
}
