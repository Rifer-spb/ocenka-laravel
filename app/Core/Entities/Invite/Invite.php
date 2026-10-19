<?php

namespace App\Core\Entities\Invite;

use App\Core\Attributes\TestClass;
use App\Core\Entities\Employee\Employee;
use App\Core\Finders\InviteFinder;
use App\Core\Entities\AbstractEntity;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\User;
use Carbon\Carbon;
use Database\Factories\Core\Entities\Invite\InviteFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\Unit\Core\Entities\Invite\InviteCompleteTest;
use Tests\Unit\Core\Entities\Invite\InviteConfirmTest;
use Tests\Unit\Core\Entities\Invite\InviteCreateTest;
use Tests\Unit\Core\Entities\Invite\InviteForWhoTest;
use Tests\Unit\Core\Entities\Invite\InviteGetForWhoUser;
use Tests\Unit\Core\Entities\Invite\InviteStatusTest;

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
 * @property Employee $employee
 *
 * @method static InviteFactory factory
 */
class Invite extends AbstractEntity
{
    public $timestamps = false;

    /**
     * @param Phys $phys
     * @param Legal $legal
     * @param InviteForWho $for
     * @return self
     * @throws \Throwable
     */
    #[TestClass(InviteCreateTest::class)]
    public static function createNew(Phys $phys, Legal $legal, InviteForWho $for): self
    {
        if (InviteFinder::hasWait($phys, $legal)) {
            throw new \DomainException('Заявка с указанным уже существует.');
        }

        if (InviteFinder::hasActive($phys, $legal)) {
            throw new \DomainException('Связь с указанным уже установлена.');
        }

        $invite = new self();
        $invite->phys_id = $phys->id;
        $invite->legal_id = $legal->id;
        $invite->for = $for->value;
        $invite->status = InviteStatus::WAIT->value;
        $invite->saveOrFail();

        return $invite;
    }

    #[TestClass(InviteStatusTest::class)]
    public function isActive(): bool
    {
        return $this->status == InviteStatus::ACTIVE->value;
    }

    #[TestClass(InviteStatusTest::class)]
    public function isWait(): bool
    {
        return $this->status == InviteStatus::WAIT->value;
    }

    #[TestClass(InviteStatusTest::class)]
    public function isComplete(): bool
    {
        return $this->status == InviteStatus::COMPLETE->value;
    }

    #[TestClass(InviteConfirmTest::class)]
    public function confirm(): void
    {
        if (! $this->isWait()) {
            throw new \DomainException('Заявка должна быть в статусе ожидания.');
        }

        $this->status = InviteStatus::ACTIVE->value;
    }

    #[TestClass(InviteCompleteTest::class)]
    public function complete(): void
    {
        if (! $this->isActive()) {
            throw new \DomainException('Заявка должна быть в активном статусе.');
        }

        $this->completed_at = Carbon::now();
        $this->status = InviteStatus::COMPLETE->value;
    }

    #[TestClass(InviteForWhoTest::class)]
    public function isForPhys(): bool
    {
        return $this->for === InviteForWho::PHYS->value;
    }

    #[TestClass(InviteForWhoTest::class)]
    public function isForLegal(): bool
    {
        return $this->for === InviteForWho::LEGAL->value;
    }

    #[TestClass(InviteGetForWhoUser::class)]
    public function getForWhoUser(): User
    {
        return $this->isForPhys() ? $this->phys : $this->legal;
    }

    public function getCreatedAtFormated(): string
    {
        return $this->created_at->format('d.m.Y H:i');
    }

    public function getCompletedAtFormated(): string
    {
        return $this->completed_at->format('d.m.Y H:i');
    }

    public function legal(): HasOne|Legal
    {
        return $this->hasOne(Legal::class, 'id', 'legal_id');
    }

    public function phys(): HasOne|Phys
    {
        return $this->hasOne(Phys::class, 'id', 'phys_id');
    }

    public function employee(): HasOne|Employee
    {
        return $this->hasOne(Employee::class, 'invite_id', 'id');
    }
}
