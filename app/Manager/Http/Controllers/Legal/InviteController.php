<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Invite\Invite;
use App\Core\ValueObjects\Email;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\Http\Requests\Legal\Invite\CreateRequest;
use App\Manager\UseCases\Legal\Invite\ConfirmUseCase;
use App\Manager\UseCases\Legal\Invite\CreateUseCase;
use App\Manager\UseCases\Legal\Invite\GetPageDataUseCase;
use App\Manager\UseCases\Legal\Invite\RefuseUseCase;
use App\Manager\UseCases\Legal\Invite\ResendUseCase;
use App\Manager\UseCases\Legal\Invite\RevokeUseCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class InviteController extends AbstractController
{
    public function view(InviteSearchRequest $request, GetPageDataUseCase $useCase)
    {
        $view = $useCase->execute($this->getUser(), $request);

        return Inertia::render('manager/legal/settings/persons/index', $view);
    }

    public function create(CreateRequest $request, CreateUseCase $useCase)
    {
        $useCase->execute($this->getUser(), new Email($request->email));

        return back()->with('success', 'Заявка успешно отправлена');
    }

    public function reSend(Invite $invite, ResendUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $invite->id);

        return back()->with('success', 'Заявка успешно отправлена повторно');
    }

    /**
     * @throws \Throwable
     */
    public function cancel(Invite $invite, RefuseUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $invite->id);

        return back()->with('success', 'Заявка успешно отменена');
    }

    /**
     * @return RedirectResponse
     *
     * @throws \Throwable
     */
    public function confirm(Invite $invite, ConfirmUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $invite->id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }

    /**
     * @return RedirectResponse
     *
     * @throws \Throwable
     */
    public function complete(Invite $invite, RevokeUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $invite->id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }
}
