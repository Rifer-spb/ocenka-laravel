<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Invite\Invite;
use App\Core\Services\InviteService;
use App\Core\ValueObjects\Email;
use App\Manager\Http\Requests\Phys\Invite\CreateRequest;
use Illuminate\Http\RedirectResponse;

class InviteController extends AbstractController
{
    public function __construct(
        private InviteService $service,
    )
    {
        $this->middleware('can:own,invite');
    }

    /**
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Phys\Invite\CreateUseCaseTest
     */
    public function create(CreateRequest $request)
    {
        $this->service->createForLegal(
            $this->getUserId(),
            new Email($request->email),
        );

        return back()->with('success', 'Заявка успешно отправлена');
    }

    /**
     * @param Invite $invite
     * @return RedirectResponse
     * @see \Feature\Manager\Http\Controllers\Phys\Invite\ResendUseCaseTest
     */
    public function reSend(Invite $invite)
    {
        $this->service->reSendEmail($invite->id);

        return back()->with('success', 'Заявка успешно отправлена повторно');
    }

    /**
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Phys\Invite\CancelUseCaseTest
     */
    public function cancel(Invite $invite)
    {
        $this->service->cancel($invite->id);

        return back()->with('success', 'Заявка успешно отменена');
    }

    /**
     * @param Invite $invite
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Phys\Invite\ConfirmUseCaseTest
     */
    public function confirm(Invite $invite)
    {
        $this->service->confirm($invite->id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }
}
