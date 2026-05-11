<?php

namespace App\Core\Models\Employee;

use App\Core\Models\AbstractEntity;

/**
 * @property int $id
 * @property int $employee_id
 * @property int $legal_id
 * @property int $phys_id
 * @property int $direction_id
 * @property bool $do
 * @property bool $write
 */
class EmployeeReportAccess extends AbstractEntity
{
    protected $fillable = [
        'direction_id',
        'phys_id',
        'legal_id',
    ];
}
