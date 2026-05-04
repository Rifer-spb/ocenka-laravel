<?php

namespace App\Manager\Modules\Phys\Http\Controllers\legal;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Legal\LegalInviteTab;
use App\Manager\Finders\Legal\InviteFinder;
use App\Manager\Modules\Phys\Http\Requests\Legal\Invite\CreateRequest;
use App\Manager\Modules\Phys\Http\Requests\Legal\Invite\SearchRequest;
use App\Manager\Modules\Phys\Readers\Legal\InviteSearcher;
use App\Manager\Modules\Phys\UseCases\legal\InviteService;
use Inertia\Inertia;

class InviteController extends AbstractController
{
    public function __construct(
        private InviteFinder $finder,
        private InviteService $service
    ) {}

    public function view(SearchRequest $searchRequest, InviteSearcher $searcher)
    {
        return Inertia::render('manager/phys/settings/legals/index', [
            'tabs' => LegalInviteTab::all(),
            'invites' => $searcher->search($this->getUser(), $searchRequest),
            'counts' => $this->finder->getCounts($this->getUser()),
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

    public function reSend(int $id)
    {
        $this->service->reSend($id, $this->getUserId());

        return redirect()->back()->with('success', 'Заявка успешно отправлена повторно');
    }

    public function cancel(int $id)
    {
        $this->service->cancel($id, $this->getUserId());

        return redirect()->back()->with('success', 'Заявка успешно отменена');
    }
}
