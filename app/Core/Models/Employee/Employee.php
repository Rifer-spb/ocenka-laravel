<?php

namespace App\Core\Models\Employee;

use App\Core\Models\AbstractEntity;
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
