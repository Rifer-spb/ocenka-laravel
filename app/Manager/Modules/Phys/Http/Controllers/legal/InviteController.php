<?php

namespace App\Manager\Modules\Phys\Http\Controllers\legal;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\Modules\Phys\Http\Requests\Legal\Invite\CreateRequest;
use App\Manager\Modules\Phys\UseCases\legal\InviteService;
use App\Manager\Modules\Phys\Views\legal\InviteView;
use Inertia\Inertia;

class InviteController extends AbstractController
{
    public function __construct(
        private InviteService $service
    ) {}

    public function view(InviteSearchRequest $request, InviteView $view)
    {
        $view = $view->get($this->getUser(), $request);

        return Inertia::render('manager/phys/settings/legals/index', $view);
    }

    /**
     * @throws \Throwable
     */
    public function create(CreateRequest $request)
    {
        $this->service->create($this->getUserId(), $request);

        return back()->with('success', 'Заявка успешно отправлена');
    }

    public function reSend(int $id)
    {
        $this->service->reSend($id, $this->getUserId());

        return back()->with('success', 'Заявка успешно отправлена повторно');
    }

    public function cancel(int $id)
    {
        $this->service->cancel($id, $this->getUserId());

        return back()->with('success', 'Заявка успешно отменена');
    }
}
