<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Notary\Notary;
use App\Core\Services\NotaryService;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\Site;
use App\Manager\Http\Requests\Phys\Notary\SearchRequest;
use App\Manager\Http\Requests\Phys\Notary\UpdateRequest;
use App\Manager\PageData\Phys\NotaryPageData;
use App\Manager\UseCases\Phys\Notary\ExportSearchUseCase;
use App\Manager\UseCases\Phys\Notary\GetNotaryUseCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class NotaryController extends AbstractController
{
    public function __construct(
        private NotaryService $service
    )
    {
    }

    public function viewIndex(SearchRequest $request, NotaryPageData $useCase)
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

    /**
     * @param Notary $notary
     * @param UpdateRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function updateNotary(Notary $notary, UpdateRequest $request)
    {
        $this->service->update(
            $notary->id,
            array_map(fn(string $email) => new Email($email), $request->emails),
            $request->site ? new Site($request->site) : null,
            $request->useDigitalReport,
            $request->comment
        );

        return back()->with('success', 'Успешно обновлено');
    }

    public function exportSearch(SearchRequest $request, ExportSearchUseCase $useCase)
    {
        $csvFile = $useCase->execute($request);

        return response()
            ->download($csvFile->getPath(), 'Нотариусы.csv')
            ->deleteFileAfterSend();
    }
}
