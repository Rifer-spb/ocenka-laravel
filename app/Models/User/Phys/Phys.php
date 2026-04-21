<?php

namespace App\Models\User\Phys;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
            $builder->where('role', 'phys');
        });
    }

    public function profile(): HasOne|PhysProfile
    {
        return $this->hasOne(PhysProfile::class, 'id', 'id');
    }
}
