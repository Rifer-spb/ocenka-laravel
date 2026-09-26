<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Finder\User\PhysFinder;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Employee\Employee;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\User\Phys\Phys;
use App\Core\Services\EmployeeService;
use App\Core\Services\InviteService;
use App\Core\ValueObjects\Email;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\Http\Requests\Legal\Invite\CreateRequest;
use App\Manager\Http\Requests\Legal\Invite\UpdateWorkRateRequest;
use App\Manager\PageData\Legal\Settings\InvitePageData;
use App\Manager\UseCases\Legal\Employee\UpdateDoReportUseCase;
use App\Manager\UseCases\Legal\Employee\UpdateManagerUseCase;
use App\Manager\UseCases\Legal\Employee\UpdateRideUseCase;
use App\Manager\UseCases\Legal\Employee\UpdateWorkRateUseCase;
use App\Manager\UseCases\Legal\Employee\UpdateWriteReportUseCase;
use App\Manager\UseCases\Legal\Invite\CancelUseCase;
use App\Manager\UseCases\Legal\Invite\CloseUseCase;
use App\Manager\UseCases\Legal\Invite\ConfirmUseCase;
use App\Manager\UseCases\Legal\Invite\CreateUseCase;
use App\Manager\UseCases\Legal\Invite\ResendUseCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class EmployeeController extends AbstractController
{
    public function __construct(
        private EmployeeService $employeeService,
    )
    {
    }

    public function view(InviteSearchRequest $request, InvitePageData $useCase)
    {
        $view = $useCase->execute($this->getUser(), $request);

        return Inertia::render('manager/legal/settings/invites/index', $view);
    }

    /**
     * @param CreateRequest $request
     * @return RedirectResponse
     * @throws \Exception
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\CreateUseCaseTest
     */
    public function create(CreateRequest $request)
    {
        $phys = PhysFinder::getByUsername($request->email);

        $this->inviteService->create($this->getUser(), $phys, InviteForWho::PHYS);

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
        $this->authorize('belongsTo', $invite);

        $this->inviteService->reSendEmail($invite);

        return back()->with('success', 'Заявка успешно отправлена повторно');
    }

    /**
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\CancelUseCaseTest
     */
    public function cancel(Invite $invite)
    {
        $this->authorize('belongsTo', $invite);

        $this->inviteService->cancel($invite);

        return back()->with('success', 'Заявка успешно отменена');
    }

    /**
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\ConfirmUseCaseTest
     */
    public function confirm(Invite $invite)
    {
        $this->authorize('belongsTo', $invite);

        $this->inviteService->confirm($invite);

        return back()->with('success', 'Заявка успешно подтверждена');
    }

    /**
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\CloseUseCaseTest
     */
    public function close(Invite $invite)
    {
        $this->authorize('belongsTo', $invite);

        $this->inviteService->close($invite);

        return back()->with('success', 'Заявка успешно завершена');
    }

    /**
     * @param Employee $employee
     * @param int $accessId
     * @return RedirectResponse
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\UpdateDoReportUseCaseTest
     */
    public function updateDoReport(Employee $employee, int $accessId)
    {
        $this->employeeService->switchDoReportAccess($employee, $accessId);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param Invite $invite
     * @param int $accessId
     * @param UpdateWriteReportUseCase $useCase
     * @return RedirectResponse
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\UpdateWriteReportUseCaseTest
     */
    public function updateWriteReport(Employee $employee, int $accessId, UpdateWriteReportUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $invite->id, $accessId);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\UpdateRideUseCaseTest
     */
    public function updateRide(Invite $invite, UpdateRideUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $invite->id);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param Invite $invite
     * @param UpdateManagerUseCase $useCase
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\UpdateManagerUseCaseTest
     */
    public function updateManager(Invite $invite, UpdateManagerUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $invite->id);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param Invite $invite
     * @param UpdateWorkRateRequest $request
     * @param UpdateWorkRateUseCase $useCase
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\UpdateWorkRateUseCaseTest
     */
    public function updateWorkRate(Invite $invite, UpdateWorkRateRequest $request, UpdateWorkRateUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $invite->id, $request->value);

        return back()->with('success', 'Успешно обновлено');
    }
}
