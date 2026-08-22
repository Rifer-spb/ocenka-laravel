<?php

namespace App\Core\Models\User\Phys;

use App\Core\Helpers\UserHelper;
use App\Core\Models\Employee\Employee;
use App\Core\Models\Employee\EmployeeReportAccess;
use App\Core\Models\Employee\EmployeeRideAccess;
use App\Core\Models\User\Role;
use App\Core\Models\User\User;
use App\Core\Models\User\ValueObjects\FirstName;
use App\Core\Models\User\ValueObjects\LastName;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\Models\User\ValueObjects\SecondName;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\NationalPhone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * @property PhysProfile $profile
 * @property PhysPhone[] $phones
 * @property Employee $employee
 * @property Collection|EmployeeReportAccess $reportAccesses
 * @property EmployeeRideAccess $rideAccess
 */
class Phys extends User
{
    /**
     * @param Email $email
     * @param Password $password
     * @return self
     *
     * Тесты @see \Tests\Unit\Core\Models\User\Phys\CreateTest
     */
    public static function new(Email $email, Password $password): self
    {
        $user = parent::create([
            'username' => $email->getValue(),
            'email' => $email->getValue(),
            'password' => $password->getValue(),
            'role' => Role::PHYS->value,
            'email_verify_token' => Str::random(60),
        ]);

        PhysProfile::create(['id' => $user->id]);

        return $user;
    }

    protected static function booted(): void
    {
        static::addGlobalScope('phys_role', function (Builder $builder) {
            $builder->where('role', Role::PHYS->value);
        });
    }

    /**
     * @param FirstName $firstName
     * @param SecondName $secondName
     * @param LastName $lastName
     * @return void
     *
     * Тесты @see \Tests\Unit\Core\Models\User\Phys\UpdateNameTest
     */
    public function updateName(FirstName $firstName, SecondName $secondName, LastName $lastName): void
    {
        $this->profile->updateName($firstName, $secondName, $lastName);
    }

    /**
     * @param NationalPhone $phone
     * @return PhysPhone
     *
     * Тесты @see \Tests\Unit\Core\Models\User\Phys\Phone\AddPhoneTest
     */
    public function addPhone(NationalPhone $phone): PhysPhone
    {
        if ($this->hasPhone($phone->getValue())) {
            throw new \DomainException("Номер телефона {$phone->getValue()} уже добавлен.");
        }

        return $this->phones()->create(['phone' => $phone->getValue()]);
    }

    public function hasPhone(int|string $phone): bool
    {
        return $this->phones()->where('phone', $phone)->exists();
    }

    /**
     * @param int $id
     * @return void
     *
     * Тесты @see \Tests\Unit\Core\Models\User\Phys\Phone\DeletePhoneTest
     */
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
