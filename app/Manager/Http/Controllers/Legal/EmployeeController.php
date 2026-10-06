<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Entities\Employee\Employee;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Services\EmployeeService;
use App\Manager\Http\Requests\Legal\Invite\UpdateWorkRateRequest;
use Illuminate\Http\RedirectResponse;

class EmployeeController extends AbstractController
{
    public function __construct(
        private EmployeeService $service
    )
    {
    }

    /**
     * @param Employee $employee
     * @param int $accessId
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\UpdateDoReportUseCaseTest
     */
    public function updateDoReport(Employee $employee, int $accessId)
    {
        $this->checkEmployeeAccess($employee);

        $this->service->updateDoReportAccess($employee->id, $accessId);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param Employee $employee
     * @param int $accessId
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\UpdateWriteReportUseCaseTest
     */
    public function updateWriteReport(Employee $employee, int $accessId)
    {
        $this->checkEmployeeAccess($employee);

        $this->service->switchWriteReportAccess($employee->id, $accessId);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\UpdateRideUseCaseTest
     */
    public function updateRide(Employee $employee)
    {
        $this->checkEmployeeAccess($employee);

        $this->service->switchRideAccess($employee->id);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param Employee $employee
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\UpdateManagerUseCaseTest
     */
    public function updateManager(Employee $employee)
    {
        $this->checkEmployeeAccess($employee);

        $this->service->switchIsManagerAccess($employee->id);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param Employee $employee
     * @param UpdateWorkRateRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     * @see \Feature\Manager\Http\Controllers\Legal\Invite\UpdateWorkRateUseCaseTest
     */
    public function updateWorkRate(Employee $employee, UpdateWorkRateRequest $request)
    {
        $this->checkEmployeeAccess($employee);

        $this->service->updateWorkRate($employee->id, $request->work_rate);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param Employee $employee
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function updateCall(Employee $employee)
    {
        $this->checkEmployeeAccess($employee);

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
        $this->checkEmployeeAccess($employee);

        $this->service->switchCanRegistryAccess($employee->id);

        return back()->with(['success' => 'Успешно сохранено']);
    }

    private function checkEmployeeAccess(Employee $employee): void
    {
        if ($employee->legal_id !== $this->getUserId()) {
            abort(404);
        }
    }
}
