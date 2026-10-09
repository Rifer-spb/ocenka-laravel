<?php

namespace App\Core\Entities\User;

use App\Core\Entities\AbstractEntityTrait;
use App\Core\Entities\ModelHelperMethods;
use App\Core\Entities\User\ValueObjects\Password;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

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
    use Notifiable;
    use HasFactory;
    use ModelHelperMethods;
    use AbstractEntityTrait;

    protected $table = 'users';

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

    public function changePassword(Password $oldPassword, Password $newPassword): void
    {
        if (! Hash::check($oldPassword->getValue(), $this->password)) {
            throw new \DomainException('Неверный текущий пароль.');
        }

        $this->updatePassword($newPassword);
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
