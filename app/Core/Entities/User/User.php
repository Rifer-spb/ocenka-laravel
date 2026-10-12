<?php

namespace App\Core\Entities\User;

use App\Core\Attributes\TestClass;
use App\Core\Entities\AbstractEntityTrait;
use App\Core\Entities\ModelHelperMethods;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\Unit\Core\Entities\User\ChangePasswordTest;

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

    /**
     * @throws \Throwable
     */
    protected static function newManager(Email $email, Password $password, Role $role): static
    {
        $user = new static();
        $user->username = $email->getValue();
        $user->email = $email->getValue();
        $user->password = $password->getValue();
        $user->role = $role->value;
        $user->email_verify_token = Str::random(60);
        $user->saveOrFail();

        return $user;
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

    #[TestClass(ChangePasswordTest::class)]
    public function updatePassword(Password $password): void
    {
        $this->password = $password->getValue();
    }
}
