<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Attributes\TestClass;
use App\Core\Entities\Notary\Notary;
use App\Core\Entities\Notary\NotaryUpdateData;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Services\NotaryService;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\Site;
use App\Manager\Http\Requests\Phys\Notary\SearchRequest;
use App\Manager\Http\Requests\Phys\Notary\UpdateRequest;
use App\Manager\ReadServices\Phys\PhysNotaryExportService;
use App\Manager\ReadServices\Phys\PhysNotaryReadService;
use Illuminate\Http\RedirectResponse;
use Tests\Feature\Manager\Http\Controllers\Phys\Notary\UpdateTest;

class NotaryController extends AbstractController
{
    public function __construct(
        private NotaryService $service,
        private PhysNotaryReadService $readService,
        private PhysNotaryExportService $exportService,
    )
    {
    }

    public function getNotary(Notary $notary)
    {
        $notary = $this->readService->getNotary($notary);

        return response()->json($notary);
    }

    /**
     * @param Notary $notary
     * @param UpdateRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[TestClass(UpdateTest::class)]
    public function updateNotary(Notary $notary, UpdateRequest $request)
    {
        $this->service->update(
            $notary->id,
            new NotaryUpdateData(
                array_map(fn(string $email) => new Email($email), $request->emails),
                $request->site ? new Site($request->site) : null,
                $request->useDigitalReport,
                $request->comment
            )
        );

        return back()->with('success', 'Успешно обновлено');
    }

    public function exportSearch(SearchRequest $request)
    {
        $csvFile = $this->exportService->toCsv($request);

        return response()
            ->download($csvFile->getPath(), 'Нотариусы.csv')
            ->deleteFileAfterSend();
    }
}
