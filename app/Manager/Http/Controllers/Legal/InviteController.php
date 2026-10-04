<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Invite\Invite;
use App\Core\Services\InviteService;
use App\Core\ValueObjects\Email;
use App\Manager\Http\Requests\Legal\Invite\CreateRequest;
use Illuminate\Http\RedirectResponse;

class InviteController extends AbstractController
{
    public function __construct(
        private InviteService $inviteService
    )
    {
        $this->middleware('can:own,invite');
    }

    /**
     * @param CreateRequest $request
     * @return RedirectResponse
     * @throws \Exception
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\CreateUseCaseTest
     */
    public function create(CreateRequest $request)
    {
        $this->inviteService->createForPhys(
            $this->getUserId(),
            new Email($request->email)
        );

        return back()->with('success', 'Заявка успешно отправлена');
    }

    /**
     * @param Invite $invite
     * @return RedirectResponse
     * @throws \Exception
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\ResendUseCaseTest
     */
    public function reSend(Invite $invite)
    {
        $this->inviteService->reSendEmail($invite->id);

        return back()->with('success', 'Заявка успешно отправлена повторно');
    }

    /**
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\CancelUseCaseTest
     */
    public function cancel(Invite $invite)
    {
        $this->inviteService->cancel($invite->id);

        return back()->with('success', 'Заявка успешно отменена');
    }

    /**
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\ConfirmUseCaseTest
     */
    public function confirm(Invite $invite)
    {
        $this->inviteService->confirm($invite->id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }

    /**
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\CloseUseCaseTest
     */
    public function close(Invite $invite)
    {
        $this->inviteService->close($invite->id);

        return back()->with('success', 'Заявка успешно завершена');
    }
}
