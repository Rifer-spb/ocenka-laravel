<?php

namespace App\Manager\Modules\Legal\Http\Controllers;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\Modules\Legal\Http\Requests\Invite\CreateRequest;
use App\Manager\Modules\Legal\UseCases\InviteService;
use App\Manager\Modules\Legal\Views\InviteView;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class InviteController extends AbstractController
{
    public function __construct(
        private InviteService $service
    ) {}

    public function view(InviteSearchRequest $request, InviteView $view)
    {
        $view = $view->get($this->getUser(), $request);

        return Inertia::render('manager/legal/settings/persons/index', $view);
    }

    public function create(CreateRequest $request)
    {
        $this->service->create($this->getUserId(), $request->email);

        return back()->with('success', 'Заявка успешно отправлена');
    }

    public function reSend(int $id)
    {
        $this->service->reSend($id);

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

    /**
     * @return RedirectResponse
     *
     * @throws \Throwable
     */
    public function confirm(int $id)
    {
        $this->service->confirm($id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }

    /**
     * @return RedirectResponse
     *
     * @throws \Throwable
     */
    public function complete(int $id)
    {
        $this->service->complete($id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }
}
