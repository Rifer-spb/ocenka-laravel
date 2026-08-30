<?php

namespace App\Core\Models\Employee;

use App\Core\Models\AbstractEntity;
use App\Core\Models\Direction;
use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $legal_id
 * @property int $phys_id
 * @property bool $is_manager
 * @property int $work_rate
 * @property Legal $legal
 * @property Phys $phys
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

        EmployeeRideAccess::create([
            'employee_id' => $employee->id,
            'phys_id' => $invite->phys_id,
            'legal_id' => $invite->legal_id,
        ]);

        return $employee;
    }

    public static function getByPhysId(int $physId): Employee
    {
        $model = self::where('phys_id', $physId)->first();

        if (! $model) {
            throw new \DomainException('Сотрудник не найден.');
        }

        return $model;
    }

    public function reportAccess(): HasMany|EmployeeReportAccess
    {
        return $this->hasMany(EmployeeReportAccess::class, 'employee_id', 'id');
    }

    public function rideAccess(): HasMany|EmployeeRideAccess
    {
        return $this->hasMany(EmployeeRideAccess::class, 'employee_id', 'id');
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
