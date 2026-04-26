<?php

namespace App\Core\Models\Legal;

use App\Core\Models\AbstractEntity;
use App\Core\Models\Direction;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $legal_id
 * @property int $phys_id
 * @property int $for
 * @property int $status
 * @property bool $is_manager
 * @property int $work_rate
 * @property string|Carbon $created_at
 * @property string|Carbon $rejected_at
 * @property string|Carbon $fired_at
 * @property Legal $legal
 * @property Phys $phys
 */
class LegalEmployee extends AbstractEntity
{
    const FOR_PHYS = 1;

    const FOR_LEGAL = 2;

    public $timestamps = false;

    protected $fillable = [
        'phys_id',
        'legal_id',
        'for',
        'status',
    ];

    /**
     * @throws \Throwable
     */
    private static function new(Phys $phys, Legal $legal, int $for): self
    {
        return self::create([
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'for' => $for,
            'status' => LegalEmployeeStatus::WAIT->value,
        ]);
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

    public function confirm(): void
    {
        if (! $this->isWait()) {
            throw new \DomainException('Заявка должна быть в статусе ожидания.');
        }

        $directions = Direction::all();

        foreach ($directions as $direction) {
            $this->reportAccess()->create([
                'phys_id' => $this->phys_id,
                'legal_id' => $this->legal_id,
                'direction_id' => $direction->id,
            ]);

            $this->rideAccess()->create([
                'phys_id' => $this->phys_id,
                'legal_id' => $this->legal_id,
            ]);
        }
    }

    public function isActive(): bool
    {
        return $this->status == LegalEmployeeStatus::ACTIVE->value;
    }

    public function isWait(): bool
    {
        return $this->status == LegalEmployeeStatus::WAIT->value;
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
            'status' => LegalEmployeeStatus::WAIT->value,
        ]);
    }

    public static function findActive(Phys $phys, Legal $legal): ?self
    {
        return self::find([
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'status' => LegalEmployeeStatus::ACTIVE->value,
        ]);
    }

    public function getFormatedCreatedAt(): string
    {
        return $this->created_at->format('d.m.Y H:i');
    }

    public function getFormatedRejectedAt(): string
    {
        return $this->rejected_at->format('d.m.Y H:i');
    }

    public function getFormatedFiredAt(): string
    {
        return $this->fired_at->format('d.m.Y H:i');
    }

    public function reportAccess(): HasMany|LegalEmployeeReportAccess
    {
        return $this->hasMany(LegalEmployeeReportAccess::class, 'legal_employee_id', 'id');
    }

    public function rideAccess(): HasMany|LegalEmployeeRideAccess
    {
        return $this->hasMany(LegalEmployeeRideAccess::class, 'legal_employee_id', 'id');
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
