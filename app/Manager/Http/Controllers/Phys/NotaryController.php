<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Http\Requests\Phys\Notary\SearchRequest;
use App\Manager\UseCases\Phys\Notary\GetPageDataUseCase;
use Inertia\Inertia;

class NotaryController extends AbstractController
{
    public function view(SearchRequest $request, GetPageDataUseCase $useCase)
    {
        $result = $useCase->execute($this->getUser(), $request);

        return Inertia::render('manager/phys/notaries/index', $result);
    }
}
