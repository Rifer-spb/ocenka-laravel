<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Entities\Employee\Employee;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Services\EmployeeService;
use App\Manager\Http\Requests\Legal\Invite\UpdateWorkRateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmployeeController extends AbstractController
{
    public function __construct(
        private EmployeeService $service
    )
    {
        $this->middleware($this->checkOwn(...));
    }

    /**
     * @param Employee $employee
     * @param int $accessId
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function updateDoReport(Employee $employee, int $accessId)
    {
        $this->service->switchDoReportAccess($employee->id, $accessId);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param Employee $employee
     * @param int $accessId
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function updateWriteReport(Employee $employee, int $accessId)
    {
        $this->service->switchWriteReportAccess($employee->id, $accessId);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @throws \Throwable
     */
    public function updateRide(Employee $employee)
    {
        $this->service->switchRideAccess($employee->id);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param Employee $employee
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function updateManager(Employee $employee)
    {
        $this->service->switchIsManagerAccess($employee->id);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param Employee $employee
     * @param UpdateWorkRateRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function updateWorkRate(Employee $employee, UpdateWorkRateRequest $request)
    {
        $this->service->updateWorkRate($employee->id, $request->value);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param Employee $employee
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function updateCall(Employee $employee)
    {
        $this->service->switchCanCallAccess($employee->id);

        return back()->with(['success' => 'Успешно сохранено']);
    }

    /**
     * @param Employee $employee
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function updateRegistry(Employee $employee)
    {
        $this->service->switchCanRegistryAccess($employee->id);

        return back()->with(['success' => 'Успешно сохранено']);
    }

    private function checkOwn(Request $request, \Closure $next)
    {
        /** @var Employee $employee */
        $employee = $request->route('employee');

        $isOwner = $employee->legal_id == $this->getUserId();

        if (! $isOwner) {
            abort(404);
        }

        return $next($request);
    }
}
