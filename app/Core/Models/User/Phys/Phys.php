<?php

namespace App\Core\Models\User\Phys;

use App\Core\Helpers\UserHelper;
use App\Core\Models\Employee\Employee;
use App\Core\Models\Employee\EmployeeReportAccess;
use App\Core\Models\Employee\EmployeeRideAccess;
use App\Core\Models\User\Role;
use App\Core\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property PhysProfile $profile
 * @property PhysPhone[] $phones
 * @property Employee $employee
 * @property Collection|EmployeeReportAccess $reportAccesses
 * @property EmployeeRideAccess $rideAccess
 */
class Phys extends User
{
    public static function signUpManager(string $email, string $password, string $role): static
    {
        $user = parent::signUpManager($email, $password, $role);

        PhysProfile::create(['id' => $user->id]);

        return $user;
    }

    protected static function booted(): void
    {
        static::addGlobalScope('phys_role', function (Builder $builder) {
            $builder->where('role', Role::PHYS->value);
        });
    }

    public function updateName(string $firstName, string $secondName, string $lastName): void
    {
        $this->profile->updateName($firstName, $secondName, $lastName);
    }

    public function addPhone(string $phone): void
    {
        $this->phones()->create(['phone' => $phone]);
    }

    public function deletePhone(int $id): void
    {
        $this->phones()->findOrFail($id)->delete();
    }

    public function updateHoliday(string $from, string $to): void
    {
        $this->profile->updateHoliday($from, $to);
    }

    public function getFullName(): string
    {
        return $this->profile->full_name ?? $this->username;
    }

    public function getName(): string
    {
        return ! empty($this->profile->full_name)
            ? UserHelper::getShortName($this->profile->full_name)
            : $this->username;
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'phys_id', 'id');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(PhysProfile::class, 'id', 'id');
    }

    public function phones(): HasMany
    {
        return $this->hasMany(PhysPhone::class, 'user_id', 'id');
    }

    public function reportAccesses(): HasMany
    {
        return $this->hasMany(EmployeeReportAccess::class, 'phys_id', 'id');
    }

    public function rideAccess(): HasOne
    {
        return $this->hasOne(EmployeeRideAccess::class, 'phys_id', 'id');
    }
}
