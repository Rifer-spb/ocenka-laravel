<?php

namespace App\Core\Models\Invite;

use App\Core\Models\AbstractEntity;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\User;
use App\Manager\Finders\InviteFinder;
use Carbon\Carbon;
use Database\Factories\Core\Models\Invite\InviteFactory;
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
 *
 * @method static InviteFactory factory
 */
class Invite extends AbstractEntity
{
    public $timestamps = false;

    protected $fillable = [
        'phys_id',
        'legal_id',
        'for',
        'status',
    ];

    /**
     * @param Phys $phys
     * @param Legal $legal
     * @param InviteForWho $for
     * @return self
     *
     * @see \Tests\Unit\Core\Models\User\Invite\InviteCreateTest
     */
    public static function createNew(Phys $phys, Legal $legal, InviteForWho $for): self
    {
        if (InviteFinder::hasWait($phys, $legal)) {
            throw new \DomainException('Заявка с указанным уже существует.');
        }

        if (InviteFinder::hasActive($phys, $legal)) {
            throw new \DomainException('Связь с указанным уже установлена.');
        }

        return self::create([
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'for' => $for->value,
            'status' => InviteStatus::WAIT->value,
        ]);
    }

    /**
     * @return bool
     *
     * @see \Tests\Unit\Core\Models\User\Invite\InviteStatusTest
     */
    public function isActive(): bool
    {
        return $this->status == InviteStatus::ACTIVE->value;
    }

    /**
     * @return bool
     *
     * @see \Tests\Unit\Core\Models\User\Invite\InviteStatusTest
     */
    public function isWait(): bool
    {
        return $this->status == InviteStatus::WAIT->value;
    }

    /**
     * @return bool
     *
     * @see \Tests\Unit\Core\Models\User\Invite\InviteStatusTest
     */
    public function isComplete(): bool
    {
        return $this->status == InviteStatus::COMPLETE->value;
    }

    public function getCreatedAtFormated(): string
    {
        return $this->created_at->format('d.m.Y H:i');
    }

    public function getCompletedAtFormated(): string
    {
        return $this->completed_at->format('d.m.Y H:i');
    }

    /**
     * @return void
     *
     * @see \Tests\Unit\Core\Models\User\Invite\InviteConfirmTest
     */
    public function confirm(): void
    {
        if (! $this->isWait()) {
            throw new \DomainException('Заявка должна быть в статусе ожидания.');
        }

        $this->status = InviteStatus::ACTIVE->value;
    }

    /**
     * @return void
     *
     * @see \Tests\Unit\Core\Models\User\Invite\InviteCompleteTest
     */
    public function complete(): void
    {
        if (! $this->isActive()) {
            throw new \DomainException('Заявка должна быть в активном статусе.');
        }

        $this->completed_at = Carbon::now();
        $this->status = InviteStatus::COMPLETE->value;
    }

    /**
     * @return bool
     *
     * @see \Tests\Unit\Core\Models\User\Invite\InviteForWhoTest
     */
    public function isForPhys(): bool
    {
        return $this->for === InviteForWho::PHYS->value;
    }

    /**
     * @return bool
     *
     * @see \Tests\Unit\Core\Models\User\Invite\InviteForWhoTest
     */
    public function isForLegal(): bool
    {
        return $this->for === InviteForWho::LEGAL->value;
    }

    public function getForWhoUser(): User
    {
        return $this->isForPhys() ? $this->phys : $this->legal;
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
