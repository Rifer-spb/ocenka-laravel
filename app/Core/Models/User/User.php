<?php

namespace App\Core\Models\User;

use App\Core\Models\EloquentDocMethods;
use App\Core\Models\User\ValueObjects\Password;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $username
 * @property string|null $email
 * @property string|null $email_verify_token
 * @property string|null $email_verified_at
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 * @property string $role
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use EloquentDocMethods, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'phone',
        'email_verify_token',
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

    /**
     * @param Password $password
     * @return void
     *
     * Тесты @see \Tests\Unit\Core\Models\User\ChangePasswordTest
     */
    public function updatePassword(Password $password): void
    {
        $this->password = $password->getValue();
    }
}
