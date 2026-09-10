<?php

namespace App\Core\Models\Employee;

use App\Core\Models\AbstractEntity;
use App\Core\Models\Direction;
use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $legal_id
 * @property int $phys_id
 * @property bool $is_manager
 * @property int $work_rate
 * @property bool $can_ride
 * @property Legal $legal
 * @property Phys $phys
 * @property Collection|EmployeeReportAccess[] $reportAccess
 */
class Employee extends AbstractEntity
{
    public $timestamps = false;

    protected $fillable = [
        'phys_id',
        'legal_id',
    ];

    public static function createNew(Invite $invite): self
    {
        $employee = self::create([
            'legal_id' => $invite->legal_id,
            'phys_id' => $invite->phys_id,
        ]);

        foreach (Direction::all() as $direction) {
            EmployeeReportAccess::create([
                'employee_id' => $employee->id,
                'phys_id' => $invite->phys_id,
                'legal_id' => $invite->legal_id,
                'direction_id' => $direction->id,
            ]);
        }

        return $employee;
    }

    public function getReportAccess(int $id): EmployeeReportAccess
    {
        return $this->reportAccess()->where('id', $id)->firstOrFail();
    }

    public function switchDoReportAccess(int $id): void
    {
        $access = $this->getReportAccess($id);
        $access->do = !$access->do;
        $access->save();
    }

    public function switchWriteReportAccess(int $id): void
    {
        $access = $this->getReportAccess($id);
        $access->write = !$access->write;
        $access->save();
    }

    public function switchRideAccess(): void
    {
        $this->can_ride = !$this->can_ride;
    }

    public function switchIsManagerAccess(): void
    {
        $this->is_manager = !$this->is_manager;
    }

    public function setWorkRateAttribute(?int $value): void
    {
        $this->attributes['work_rate'] = $value > 0 ? $value : null;
    }

    public function reportAccess(): HasMany|EmployeeReportAccess
    {
        return $this->hasMany(EmployeeReportAccess::class, 'employee_id', 'id');
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
