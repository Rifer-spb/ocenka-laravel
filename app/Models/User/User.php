<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public static function signUpManager(string $email, string $password, string $role): static
    {
        return parent::create([
            'name' => $email,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ]);
    }

    public function isPhys(): bool
    {
        return $this->role === Role::PHYS->value;
    }

    public function isLegal(): bool
    {
        return $this->role === Role::LEGAL->value;
    }

    public function isClient(): bool
    {
        return $this->role === Role::CLIENT->value;
    }

    public function isNotary(): bool
    {
        return $this->role === Role::NOTARY->value;
    }
}
