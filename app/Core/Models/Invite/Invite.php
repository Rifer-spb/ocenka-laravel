<?php

namespace App\Core\Models\Invite;

use App\Core\Models\AbstractEntity;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $legal_id
 * @property int $phys_id
 * @property int $for
 * @property int $status
 * @property string|Carbon $created_at
 * @property string|Carbon $completed_at
 * @property Legal $legal
 * @property Phys $phys
 */
class Invite extends AbstractEntity
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

    private static function new(Phys $phys, Legal $legal, int $for): self
    {
        return self::create([
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'for' => $for,
            'status' => InviteStatus::WAIT->value,
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

    public function isActive(): bool
    {
        return $this->status == InviteStatus::ACTIVE->value;
    }

    public function isWait(): bool
    {
        return $this->status == InviteStatus::WAIT->value;
    }

    public static function findWait(Phys $phys, Legal $legal): ?self
    {
        return self::find([
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'status' => InviteStatus::WAIT->value,
        ]);
    }

    public static function findActive(Phys $phys, Legal $legal): ?self
    {
        return self::find([
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'status' => InviteStatus::ACTIVE->value,
        ]);
    }

    public function getCreatedAtFormated(): string
    {
        return $this->created_at->format('d.m.Y H:i');
    }

    public function getCompletedAtFormated(): string
    {
        return $this->completed_at->format('d.m.Y H:i');
    }

    public function confirm(): void
    {
        if (! $this->isWait()) {
            throw new \DomainException('Заявка должна быть в статусе ожидания.');
        }

        $this->status = InviteStatus::ACTIVE->value;
    }

    public static function getWaitById(int $id): self
    {
        $model = self::where([
            'id' => $id,
            'status' => InviteStatus::WAIT->value,
        ])->first();

        if (! $model) {
            throw new \DomainException('Заявка не найдена.');
        }

        return $model;
    }

    public static function hasActive(Phys $phys, Legal $legal): bool
    {
        return self::where('phys_id', $phys->id)
            ->where('legal_id', $legal->id)
            ->where('status', InviteStatus::ACTIVE->value)
            ->exists();
    }

    public static function hasWait(Phys $phys, Legal $legal): bool
    {
        return self::where('phys_id', $phys->id)
            ->where('legal_id', $legal->id)
            ->where('status', InviteStatus::WAIT->value)
            ->exists();
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
