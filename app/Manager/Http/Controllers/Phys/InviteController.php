<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteTab;
use App\Core\ValueObjects\Email;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\Http\Requests\Phys\Invite\CreateRequest;
use App\Manager\UseCases\Phys\Invite\ConfirmUseCase;
use App\Manager\UseCases\Phys\Invite\CancelUseCase;
use App\Manager\UseCases\Phys\Invite\CreateUseCase;
use App\Manager\UseCases\Phys\Invite\ResendUseCase;
use App\Manager\UseCases\Phys\Invite\CloseUseCase;
use App\Manager\UseCases\Phys\Invite\GetPageDataUseCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class InviteController extends AbstractController
{
    public function view(InviteSearchRequest $request, GetPageDataUseCase $useCase)
    {
        $result = $useCase->execute($this->getUser(), InviteTab::from($request->type));

        return Inertia::render('manager/phys/settings/invites/index', $result);
    }

    /**
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Phys\Invite\CreateUseCaseTest
     */
    public function create(CreateRequest $request, CreateUseCase $useCase)
    {
        $useCase->execute($this->getUser(), new Email($request->email));

        return back()->with('success', 'Заявка успешно отправлена');
    }

    /**
     * @param Invite $invite
     * @param ResendUseCase $useCase
     * @return RedirectResponse
     * @throws \Exception
     * @see \Feature\Manager\Http\Controllers\Phys\Invite\ResendUseCaseTest
     */
    public function reSend(Invite $invite, ResendUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $invite->id);

        return back()->with('success', 'Заявка успешно отправлена повторно');
    }

    /**
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Phys\Invite\CancelUseCaseTest
     */
    public function cancel(Invite $invite, CancelUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $invite->id);

        return back()->with('success', 'Заявка успешно отменена');
    }

    /**
     * @param Invite $invite
     * @param ConfirmUseCase $useCase
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Phys\Invite\ConfirmUseCaseTest
     */
    public function confirm(Invite $invite, ConfirmUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $invite->id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }
}
