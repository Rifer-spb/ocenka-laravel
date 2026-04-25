<?php

namespace App\Core\Models\User\Phys;

use App\Core\Models\User\Role;
use App\Core\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property PhysProfile $profile
 * @property PhysPhone[] $phones
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

    public function profile(): HasOne
    {
        return $this->hasOne(PhysProfile::class, 'id', 'id');
    }

    public function phones(): HasMany
    {
        return $this->hasMany(PhysPhone::class, 'user_id', 'id');
    }
}
