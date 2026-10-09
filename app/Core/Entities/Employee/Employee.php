<?php

namespace App\Core\Entities\Employee;

use App\Core\Entities\AbstractEntity;
use App\Core\Entities\Direction;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use Database\Factories\Core\Entities\Employee\EmployeeFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $invite_id
 * @property int $legal_id
 * @property int $phys_id
 * @property bool $is_manager
 * @property int $work_rate
 * @property bool $can_ride
 * @property bool $can_registry
 * @property bool $can_call
 * @property Legal $legal
 * @property Phys $phys
 * @property Collection|EmployeeReportAccess[] $reportAccess
 *
 * @method static EmployeeFactory factory()
 */
class Employee extends AbstractEntity
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'can_ride' => 'boolean',
            'is_manager' => 'boolean',
            'can_call' => 'boolean',
            'can_registry' => 'boolean',
        ];
    }

    /**
     * @param Invite $invite
     * @return self
     *
     * @throws \Throwable
     * @see \Tests\Unit\Core\Models\Employee\CreateTest
     */
    public static function createNew(Invite $invite): self
    {
        $employee = new self();
        $employee->invite_id = $invite->id;
        $employee->legal_id = $invite->legal_id;
        $employee->phys_id = $invite->phys_id;
        $employee->saveOrFail();

        foreach (Direction::all() as $direction) {
            $access = $employee->reportAccess()->make();
            $access->employee_id = $employee->id;
            $access->phys_id = $employee->phys_id;
            $access->legal_id = $employee->legal_id;
            $access->direction_id = $direction->id;
            $access->saveOrFail();
        }

        return $employee;
    }

    /**
     * @param int $id
     * @return EmployeeReportAccess
     *
     * @see \Tests\Unit\Core\Models\Employee\GetReportAccessTest
     */
    public function getReportAccess(int $id): EmployeeReportAccess
    {
        if (!$access = $this->reportAccess->find($id)) {
            throw new EntityNotFoundException('Права отчета не найдены.');
        }

        return $access;
    }

    /**
     * @param int $id
     * @return void
     *
     * @throws \Throwable
     * @see \Tests\Unit\Core\Models\Employee\SwitchAccessTest
     */
    public function switchDoReportAccess(int $id): void
    {
        $access = $this->getReportAccess($id);
        $access->do = !$access->do;
        $access->saveOrFail();
    }

    /**
     * @param int $id
     * @return void
     *
     * @throws \Throwable
     * @see \Tests\Unit\Core\Models\Employee\SwitchAccessTest
     */
    public function switchWriteReportAccess(int $id): void
    {
        $access = $this->getReportAccess($id);
        $access->write = !$access->write;
        $access->saveOrFail();
    }

    /**
     * @return void
     *
     * @see \Tests\Unit\Core\Models\Employee\SwitchAccessTest
     */
    public function switchRideAccess(): void
    {
        $this->can_ride = !$this->can_ride;
    }

    /**
     * @return void
     *
     * @see \Tests\Unit\Core\Models\Employee\SwitchAccessTest
     */
    public function switchIsManagerAccess(): void
    {
        $this->is_manager = !$this->is_manager;
    }

    public function switchCanRegistryAccess(): void
    {
        $this->can_registry = !$this->can_registry;
    }

    public function switchCanCallAccess(): void
    {
        $this->can_call = !$this->can_call;
    }

    public function reportAccess(): HasMany|EmployeeReportAccess
    {
        return $this->hasMany(EmployeeReportAccess::class, 'employee_id', 'id')->orderBy('id');
    }

    public function legal(): HasOne|Legal
    {
        return $this->hasOne(Legal::class, 'id', 'legal_id');
    }

    public function phys(): HasOne|Phys
    {
        return $this->hasOne(Phys::class, 'id', 'phys_id');
    }
}
