<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Attributes\TestClass;
use App\Core\Entities\Employee\Employee;
use App\Core\Entities\Employee\PhoneExtension;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Services\EmployeeService;
use App\Manager\Http\Requests\Legal\Employee\UpdatePhoneExtensionRequest;
use App\Manager\Http\Requests\Legal\Invite\UpdateWorkRateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Tests\Feature\Manager\Http\Controllers\Legal\Employee\UpdateDoReportTest;
use Tests\Feature\Manager\Http\Controllers\Legal\Employee\UpdatePhoneExtensionTest;
use Tests\Feature\Manager\Http\Controllers\Legal\Employee\UpdateWriteReportTest;
use Tests\Feature\Manager\Http\Controllers\Legal\Employee\UpdateCanRideTest;
use Tests\Feature\Manager\Http\Controllers\Legal\Employee\UpdateManagerTest;
use Tests\Feature\Manager\Http\Controllers\Legal\Employee\UpdateWorkRateTest;
use Tests\Feature\Manager\Http\Controllers\Legal\Employee\UpdateCanCallTest;
use Tests\Feature\Manager\Http\Controllers\Legal\Employee\UpdateCanRegistryTest;

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
    #[TestClass(UpdateDoReportTest::class)]
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
    #[TestClass(UpdateWriteReportTest::class)]
    public function updateWriteReport(Employee $employee, int $accessId)
    {
        $this->service->switchWriteReportAccess($employee->id, $accessId);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @throws \Throwable
     */
    #[TestClass(UpdateCanRideTest::class)]
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
    #[TestClass(UpdateManagerTest::class)]
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
    #[TestClass(UpdateWorkRateTest::class)]
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
    #[TestClass(UpdateCanCallTest::class)]
    public function updateCall(Employee $employee)
    {
        $this->service->switchCanCallAccess($employee->id);

        return back()->with(['success' => 'Успешно обновлено']);
    }

    /**
     * @param Employee $employee
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[TestClass(UpdateCanRegistryTest::class)]
    public function updateRegistry(Employee $employee)
    {
        $this->service->switchCanRegistryAccess($employee->id);

        return back()->with(['success' => 'Успешно обновлено']);
    }

    /**
     * @throws \Throwable
     */
    #[TestClass(UpdatePhoneExtensionTest::class)]
    public function updatePhoneExtension(Employee $employee, UpdatePhoneExtensionRequest $request)
    {
        $this->service->updatePhoneExtension($employee->id, new PhoneExtension($request->value));

        return back()->with(['success' => 'Успешно обновлено']);
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
