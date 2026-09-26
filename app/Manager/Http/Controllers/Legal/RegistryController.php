<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Employee\Employee;
use App\Core\Models\User\Legal\ValueObjects\RegistryTemplate;
use App\Manager\Http\Requests\Legal\Registry\UpdateTemplateRequest;
use App\Manager\Queries\Legal\Settings\RegistryPageData;
use App\Manager\UseCases\Legal\Employee\UpdateCanRegistryUseCase;
use App\Manager\UseCases\Legal\Profile\UpdateTemplateUseCase;
use Inertia\Inertia;

class RegistryController extends AbstractController
{
    public function view(RegistryPageData $useCase)
    {
        $result = $useCase->execute($this->getUser());

        return Inertia::render('manager/legal/settings/registry/index', $result);
    }

    public function updateTemplate(UpdateTemplateRequest $request, UpdateTemplateUseCase $useCase)
    {
        $useCase->execute($this->getUser(), new RegistryTemplate($request->template));

        return back()->with(['success' => 'Успешно сохранено']);
    }

    public function updateAccess(Employee $employee, UpdateCanRegistryUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $employee->id);

        return back()->with(['success' => 'Успешно сохранено']);
    }
}
