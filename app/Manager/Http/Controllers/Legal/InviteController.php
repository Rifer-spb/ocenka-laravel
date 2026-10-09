<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Entities\Invite\Invite;
use App\Core\Services\InviteService;
use App\Core\ValueObjects\Email;
use App\Manager\Http\Requests\Legal\Invite\CreateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InviteController extends AbstractController
{
    public function __construct(
        private InviteService $inviteService
    )
    {
        $this->middleware($this->checkOwner(...))->except('create');
    }

    /**
     * @param CreateRequest $request
     * @return RedirectResponse
     * @throws \Exception
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
     */
    public function reSend(Invite $invite)
    {
        $this->inviteService->reSendEmail($invite->id);

        return back()->with('success', 'Заявка успешно отправлена повторно');
    }

    /**
     * @throws \Throwable
     */
    public function cancel(Invite $invite)
    {
        $this->inviteService->cancel($invite->id);

        return back()->with('success', 'Заявка успешно отменена');
    }

    /**
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function confirm(Invite $invite)
    {
        $this->inviteService->confirm($invite->id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }

    /**
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function close(Invite $invite)
    {
        $this->inviteService->close($invite->id);

        return back()->with('success', 'Заявка успешно завершена');
    }

    private function checkOwner(Request $request, \Closure $next)
    {
        /** @var Invite $invite */
        $invite = $request->route('invite');

        if ($invite->legal_id != $this->getUserId()) {
            abort(404);
        }

        return $next($request);
    }
}
