<?php

namespace App\Manager\Http\PageControllers\Phys\Notaries;

use App\Core\Entities\Notary\NotaryRegion;
use App\Core\Http\Controllers\AbstractController;
use App\Core\ReadServices\NotaryRegionReadService;
use App\Manager\Http\Requests\Phys\Notary\SearchRequest;
use App\Manager\ReadServices\Phys\PhysNotarySearchService;
use Inertia\Inertia;
use Inertia\Response;

class NotariesPageController extends AbstractController
{
    public function __construct(
        private NotaryRegionReadService $regionService,
        private PhysNotarySearchService $searchService
    )
    {
    }

    public function __invoke(SearchRequest $request): Response
    {
        return Inertia::render('manager/phys/notaries/pages/index/index', $this->getData($request));
    }

    private function getData(SearchRequest $request): array
    {
        return [
            'regions' => $this->regionService->getList(),
            'notaries' => $this->searchService->search($request),
            'defaultRegionId' => NotaryRegion::ID_SAINT_PETERSBURG,
        ];
    }
}
