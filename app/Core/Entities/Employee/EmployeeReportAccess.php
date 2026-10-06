<?php

namespace App\Core\Entities\Employee;

use App\Core\Entities\AbstractEntity;
use App\Core\Entities\Direction;
use Database\Factories\Core\Models\Employee\EmployeeReportAccessFactory;
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
 *
 * @method static EmployeeReportAccessFactory factory()
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

    protected function casts(): array
    {
        return [
            'do' => 'boolean',
            'write' => 'boolean',
        ];
    }

    public function direction(): HasOne
    {
        return $this->hasOne(Direction::class, 'id', 'direction_id');
    }
}
