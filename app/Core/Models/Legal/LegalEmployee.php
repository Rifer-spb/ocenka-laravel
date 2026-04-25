<?php

namespace App\Core\Models\Legal;

use App\Core\Models\AbstractEntity;
use App\Core\Models\Direction;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $legal_id
 * @property int $phys_id
 * @property int $for
 * @property int $status
 * @property bool $is_manager
 * @property int $work_rate
 * @property string $created_at
 * @property string $rejected_at
 * @property string $fired_at
 */
class LegalEmployee extends AbstractEntity
{
    private const FOR_PHYS = 1;
    private const FOR_LEGAL = 2;
    private const STATUS_WAIT = 0;
    private const STATUS_ACTIVE = 1;
    private const STATUS_FIRED = 2;

    protected $fillable = [
        'phys_id',
        'legal_id',
        'for',
        'status',
    ];

    public $timestamps = false;

    /**
     * @throws \Throwable
     */
    private static function new(Phys $phys, Legal $legal, int $for): self
    {
        $model = self::create([
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'for' => $for,
            'status' => self::STATUS_WAIT,
        ]);

        $directions = Direction::all();

        foreach ($directions as $direction) {
            $model->reportAccess()->create([
                'phys_id' => $phys->id,
                'legal_id' => $legal->id,
                'direction_id' => $direction->id,
            ]);

            $model->rideAccess()->create([
                'phys_id' => $phys->id,
                'legal_id' => $legal->id,
            ]);
        }

        return $model;
    }

    /**
     * @throws \Throwable
     */
    public static function createByPhys(Phys $phys, Legal $legal): self
    {
        return self::new($phys, $legal, self::FOR_LEGAL);
    }

    /**
     * @throws \Throwable
     */
    public static function createByLegal(Legal $legal, Phys $phys): self
    {
        return self::new($phys, $legal, self::FOR_PHYS);
    }

    public static function hasByPhysAndLegal(Phys $phys, Legal $legal): bool
    {
        return self::where('phys_id', $phys->id)
            ->where('legal_id', $legal->id)
            ->exists();
    }

    public static function findWait(Phys $phys, Legal $legal): ?self
    {
        return self::find([
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'status' => self::STATUS_WAIT,
        ]);
    }

    public static function findActive(Phys $phys, Legal $legal): ?self
    {
        return self::find([
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function reportAccess(): HasMany|LegalEmployeeReportAccess
    {
        return $this->hasMany(LegalEmployeeReportAccess::class, 'legal_employee_id', 'id');
    }

    public function rideAccess(): HasMany|LegalEmployeeRideAccess
    {
        return $this->hasMany(LegalEmployeeRideAccess::class, 'legal_employee_id', 'id');
    }
}
