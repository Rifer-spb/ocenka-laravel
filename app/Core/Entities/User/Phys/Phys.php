<?php

namespace App\Core\Entities\User\Phys;

use App\Core\Attributes\TestClass;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Helpers\UserHelper;
use App\Core\Entities\Employee\Employee;
use App\Core\Entities\User\Phys\ValueObjects\Holiday;
use App\Core\Entities\User\Role;
use App\Core\Entities\User\User;
use App\Core\Entities\User\ValueObjects\FirstName;
use App\Core\Entities\User\ValueObjects\LastName;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\Entities\User\ValueObjects\SecondName;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\NationalPhone;
use Database\Factories\Core\Entities\User\Phys\PhysFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Tests\Unit\Core\Entities\User\Phys\CreateTest;
use Tests\Unit\Core\Entities\User\Phys\GetNameTest;
use Tests\Unit\Core\Entities\User\Phys\Phone\AddPhoneTest;
use Tests\Unit\Core\Entities\User\Phys\Phone\DeletePhoneTest;
use Tests\Unit\Core\Entities\User\Phys\Phone\GetPhoneByValueTest;
use Tests\Unit\Core\Entities\User\Phys\Phone\HasPhoneTest;
use Tests\Unit\Core\Entities\User\Phys\UpdateHolidayTest;
use Tests\Unit\Core\Entities\User\Phys\UpdateNameTest;

/**
 * @property PhysProfile $profile
 * @property Collection|PhysPhone[] $phones
 * @property Employee $employee
 *
 * @method static PhysFactory factory()
 */
class Phys extends User
{
    /**
     * @param Email $email
     * @param Password $password
     * @return self
     * @throws \Throwable
     */
    #[TestClass(CreateTest::class)]
    public static function createNew(Email $email, Password $password): self
    {
        $user = parent::newManager($email, $password, Role::PHYS);

        $user->profile()->make()->saveOrFail();

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
     * @throws \Throwable
     */
    #[TestClass(UpdateNameTest::class)]
    public function updateName(FirstName $firstName, SecondName $secondName, LastName $lastName): void
    {
        $profile = $this->profile;
        $profile->updateName($firstName, $secondName, $lastName);
        $profile->saveOrFail();
    }

    /**
     * @param NationalPhone $phone
     * @return PhysPhone
     * @throws \Throwable
     */
    #[TestClass(AddPhoneTest::class)]
    public function addPhone(NationalPhone $phone): PhysPhone
    {
        if ($this->hasPhone($phone->getValue())) {
            throw new \DomainException('Номер телефона уже добавлен.');
        }

        /** @var PhysPhone $phoneEntity */
        $phoneEntity = $this->phones()->make();
        $phoneEntity->phone = $phone->getValue();
        $phoneEntity->saveOrFail();

        $this->syncCollection('phones', $phoneEntity);

        return $phoneEntity;
    }

    #[TestClass(HasPhoneTest::class)]
    public function hasPhone(int|string $phone): bool
    {
        return $this->phones->contains('phone', $phone);
    }

    public function getPhone(int $id): PhysPhone
    {
        $phone = $this->phones->firstWhere('id', $id);

        if (! $phone) {
            throw new EntityNotFoundException('Телефон не найден.');
        }

        return $phone;
    }

    /**
     * @param int $id
     * @return void
     * @throws \Throwable
     */
    #[TestClass(DeletePhoneTest::class)]
    public function deletePhone(int $id): void
    {
        $phone = $this->getPhone($id);
        $phone->deleteOrFail();

        $this->unSyncCollection('phones', $phone);
    }

    /**
     * @param Holiday $holiday
     * @return void
     * @throws \Throwable
     */
    #[TestClass(UpdateHolidayTest::class)]
    public function updateHoliday(Holiday $holiday): void
    {
        $profile = $this->profile;
        $profile->updateHoliday($holiday);
        $profile->saveOrFail();
    }

    #[TestClass(GetNameTest::class)]
    public function getName(): string
    {
        $name = $this->profile->getShortFullName();

        return !empty($name) ? $name : $this->username;
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
}
