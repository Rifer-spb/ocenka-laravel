<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Attributes\TestClass;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Entities\Invite\Invite;
use App\Core\Services\InviteService;
use App\Core\ValueObjects\Email;
use App\Manager\Http\Requests\Phys\Invite\CreateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Tests\Feature\Manager\Http\Controllers\Phys\Invite\CancelTest;
use Tests\Feature\Manager\Http\Controllers\Phys\Invite\ConfirmTest;
use Tests\Feature\Manager\Http\Controllers\Phys\Invite\CreateTest;
use Tests\Feature\Manager\Http\Controllers\Phys\Invite\ResendTest;

class InviteController extends AbstractController
{
    public function __construct(
        private InviteService $service,
    )
    {
        $this->middleware($this->checkOwner(...))->except('create');
    }

    /**
     * @throws \Throwable
     */
    #[TestClass(CreateTest::class)]
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
     */
    #[TestClass(ResendTest::class)]
    public function reSend(Invite $invite)
    {
        $this->service->reSendEmail($invite->id);

        return back()->with('success', 'Заявка успешно отправлена повторно');
    }

    /**
     * @throws \Throwable
     */
    #[TestClass(CancelTest::class)]
    public function cancel(Invite $invite)
    {
        $this->service->cancel($invite->id);

        return back()->with('success', 'Заявка успешно отменена');
    }

    /**
     * @param Invite $invite
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[TestClass(ConfirmTest::class)]
    public function confirm(Invite $invite)
    {
        $this->service->confirm($invite->id);

        return back()->with('success', 'Заявка успешно подтверждена');
    }

    private function checkOwner(Request $request, \Closure $next)
    {
        /** @var Invite $invite */
        $invite = $request->route('invite');

        if ($invite->phys_id != $this->getUserId()) {
            abort(404);
        }

        return $next($request);
    }
}
