<?php

namespace App\Core\Models\Employee;

use App\Core\Models\AbstractEntity;

/**
 * @property int $id
 * @property int $employee_id
 * @property int $legal_id
 * @property int $phys_id
 * @property bool $access
 */
class EmployeeRideAccess extends AbstractEntity
{
    protected $table = 'employees_ride_access';

    public $timestamps = false;

    protected $fillable = [
        'phys_id',
        'legal_id',
        'employee_id',
    ];
}
