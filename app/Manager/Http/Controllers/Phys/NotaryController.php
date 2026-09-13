<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Http\Requests\Phys\Notary\SearchRequest;
use App\Manager\UseCases\Phys\Notary\GetPageDataUseCase;
use Inertia\Inertia;

class NotaryController extends AbstractController
{
    public function viewIndex(SearchRequest $request, GetPageDataUseCase $useCase)
    {
        $result = $useCase->execute($this->getUser(), $request);

        return Inertia::render('manager/phys/notaries/pages/index/index', $result);
    }

    public function viewExport()
    {
        return Inertia::render('manager/phys/notaries/pages/export/index');
    }

    public function viewRegionExport()
    {
        return Inertia::render('manager/phys/notaries/pages/regionExport/index');
    }
}
