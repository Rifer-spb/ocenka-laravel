<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Http\Controllers\AbstractController;
use App\Core\ValueObjects\Email;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\Http\Requests\Phys\Invite\CreateRequest;
use App\Manager\Modules\Phys\Views\InviteView;
use App\Manager\UseCases\Phys\Invite\RefuseUseCase;
use App\Manager\UseCases\Phys\Invite\CreateUseCase;
use App\Manager\UseCases\Phys\Invite\ResendUseCase;
use App\Manager\UseCases\Phys\Invite\RevokeUseCase;
use Inertia\Inertia;

class InviteController extends AbstractController
{
    public function view(InviteSearchRequest $request, InviteView $view)
    {
        $view = $view->get($this->getUser(), $request);

        return Inertia::render('manager/phys/settings/legals/index', $view);
    }

    /**
     * @throws \Throwable
     */
    public function create(CreateRequest $request, CreateUseCase $useCase)
    {
        $useCase->execute($this->getUser(), new Email($request->email));

        return back()->with('success', 'Заявка успешно отправлена');
    }

    public function reSend(int $id, ResendUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $id);

        return back()->with('success', 'Заявка успешно отправлена повторно');
    }

    /**
     * @throws \Throwable
     */
    public function cancel(int $id, RefuseUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $id);

        return back()->with('success', 'Заявка успешно отменена');
    }

    public function confirm(int $id, RevokeUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }
}
