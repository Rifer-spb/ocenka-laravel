<?php

namespace App\Manager\Modules\Phys\Http\Controllers;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\Modules\Phys\Http\Requests\Invite\CreateRequest;
use App\Manager\Modules\Phys\UseCases\InviteService;
use App\Manager\Modules\Phys\Views\InviteView;
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
        $this->service->create($this->getUserId(), $request->email);

        return back()->with('success', 'Заявка успешно отправлена');
    }

    public function reSend(int $id)
    {
        $this->service->reSend($id, $this->getUser());

        return back()->with('success', 'Заявка успешно отправлена повторно');
    }

    /**
     * @throws \Throwable
     */
    public function cancel(int $id)
    {
        $this->service->cancel($id);

        return back()->with('success', 'Заявка успешно отменена');
    }

    public function confirm(int $id)
    {
        $this->service->confirm($id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }
}
