<?php

namespace App\Core\Entities\User\Phys;

use App\Core\Entities\AbstractEntity;
use App\Core\Entities\User\Phys\ValueObjects\Holiday;
use App\Core\Entities\User\ValueObjects\FirstName;
use App\Core\Entities\User\ValueObjects\LastName;
use App\Core\Entities\User\ValueObjects\SecondName;
use App\Core\Helpers\UserHelper;
use Carbon\Carbon;
use Database\Factories\Core\Entities\User\Phys\PhysProfileFactory;

/**
 * @property int $id
 * @property string|null $first_name
 * @property string|null $second_name
 * @property string|null $last_name
 * @property string|null $full_name
 * @property int|null $telegram_id
 * @property bool $is_admin
 * @property string $holiday_from
 * @property string $holiday_to
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static PhysProfileFactory factory()
 */
class PhysProfile extends AbstractEntity
{
    protected $table = 'phys_profiles';

    public function updateName(FirstName $firstName, SecondName $secondName, LastName $lastName): void
    {
        $this->first_name = $firstName->getValue();
        $this->second_name = $secondName->getValue();
        $this->last_name = $lastName->getValue();
        $this->full_name = trim("{$firstName->getValue()} {$secondName->getValue()} {$lastName->getValue()}");
    }

    /**
     * @param Holiday $holiday
     * @return void
     */
    public function updateHoliday(Holiday $holiday): void
    {
        $this->holiday_from = $holiday->getFromString();
        $this->holiday_to = $holiday->getToString();
    }

    public function getShortFullName(): ?string
    {
        if (empty($this->full_name)) {
            return null;
        }

        return UserHelper::getShortName($this->full_name);
    }

    public function getHolidayFromAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }

        return Carbon::parse($value)->format('d.m.Y');
    }

    public function getHolidayToAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }

        return Carbon::parse($value)->format('d.m.Y');
    }
}
