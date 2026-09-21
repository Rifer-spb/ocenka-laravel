<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Notary\Notary;
use App\Manager\Http\Requests\Phys\Notary\SearchRequest;
use App\Manager\Http\Requests\Phys\Notary\UpdateRequest;
use App\Manager\UseCases\Phys\Notary\GetNotaryUseCase;
use App\Manager\UseCases\Phys\Notary\GetPageDataUseCase;
use Inertia\Inertia;

class NotaryController extends AbstractController
{
    public function viewIndex(SearchRequest $request, GetPageDataUseCase $useCase)
    {
        $result = $useCase->execute($request);

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

    public function getNotary(Notary $notary, GetNotaryUseCase $useCase)
    {
        $notary = $useCase->execute($notary);

        return response()->json($notary);
    }

    public function updateNotary(Notary $notary, UpdateRequest $request)
    {
        return back()->with('success', 'Успешно обновлено');
    }
}
