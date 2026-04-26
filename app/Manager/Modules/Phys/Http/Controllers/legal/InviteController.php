<?php

namespace App\Manager\Modules\Phys\Http\Controllers\legal;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Modules\Phys\Http\Requests\Legal\Invite\CreateRequest;
use App\Manager\Modules\Phys\Http\Requests\Legal\Invite\SearchRequest;
use App\Manager\Modules\Phys\Readers\Legal\InviteSearcher;
use App\Manager\Modules\Phys\UseCases\legal\InviteService;
use Inertia\Inertia;

class InviteController extends AbstractController
{
    public function __construct(
        private InviteService $service
    ) {}

    public function view(SearchRequest $searchRequest, InviteSearcher $searcher)
    {
        return Inertia::render('manager/phys/settings/legals/index', [
            'invites' => $searcher->search($this->getUser(), $searchRequest),
        ]);
    }

    public function search(SearchRequest $request, InviteSearcher $searcher)
    {
        return $searcher->search($this->getUser(), $request);
    }

    /**
     * @throws \Throwable
     */
    public function create(CreateRequest $request)
    {
        $this->service->create($this->getUserId(), $request);

        return redirect()->back()->with('success', 'Заявка успешно отправлена');
    }
}
