<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Invite\InviteTab;
use App\Core\ValueObjects\Email;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\Http\Requests\Phys\Invite\CreateRequest;
use App\Manager\UseCases\Phys\Invite\ConfirmUseCase;
use App\Manager\UseCases\Phys\Invite\RefuseUseCase;
use App\Manager\UseCases\Phys\Invite\CreateUseCase;
use App\Manager\UseCases\Phys\Invite\ResendUseCase;
use App\Manager\UseCases\Phys\Invite\RevokeUseCase;
use App\Manager\UseCases\Phys\Invite\GetPageDataUseCase;
use Inertia\Inertia;

class InviteController extends AbstractController
{
    public function view(InviteSearchRequest $request, GetPageDataUseCase $useCase)
    {
        $result = $useCase->execute($this->getUser(), InviteTab::from($request->type));

        return Inertia::render('manager/phys/settings/legals/index', $result);
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

    public function confirm(int $id, ConfirmUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }
}
