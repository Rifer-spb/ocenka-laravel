<?php

namespace App\Core\Models\Employee;

use App\Core\Models\AbstractEntity;
use App\Core\Models\Direction;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $employee_id
 * @property int $legal_id
 * @property int $phys_id
 * @property int $direction_id
 * @property bool $do
 * @property bool $write
 * @property Direction $direction
 */
class EmployeeReportAccess extends AbstractEntity
{
    public $timestamps = false;

    protected $fillable = [
        'direction_id',
        'phys_id',
        'legal_id',
        'employee_id',
    ];

    public function direction(): HasOne
    {
        return $this->hasOne(Direction::class, 'id', 'direction_id');
    }
}
