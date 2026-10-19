<?php

namespace App\Core\Entities\Employee;

use App\Core\Entities\AbstractEntity;
use App\Core\Entities\Direction;
use Database\Factories\Core\Entities\Employee\EmployeeReportAccessFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected function casts(): array
    {
        return [
            'do' => 'boolean',
            'write' => 'boolean',
        ];
    }

    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class, 'direction_id', 'id');
    }
}
