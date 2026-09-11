<?php

namespace App\Core\Models\User\Phys;

use App\Core\Models\AbstractEntity;
use App\Core\Models\User\Phys\ValueObjects\Holiday;
use App\Core\Models\User\ValueObjects\FirstName;
use App\Core\Models\User\ValueObjects\LastName;
use App\Core\Models\User\ValueObjects\SecondName;
use Carbon\Carbon;
use Database\Factories\Core\Models\User\Phys\PhysProfileFactory;

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
    protected $fillable = [
        'id',
        'first_name',
        'second_name',
        'last_name',
        'full_name',
        'holiday_from',
        'holiday_to',
    ];

    public function updateName(FirstName $firstName, SecondName $secondName, LastName $lastName): void
    {
        $this->update([
            'first_name' => $firstName->getValue(),
            'second_name' => $secondName->getValue(),
            'last_name' => $lastName->getValue(),
            'full_name' => trim("{$firstName->getValue()} {$secondName->getValue()} {$lastName->getValue()}"),
        ]);
    }

    /**
     * @param Holiday $holiday
     * @return void
     *
     * Тесты @see \Tests\Unit\Core\Models\User\Phys\UpdateHolidayTest
     */
    public function updateHoliday(Holiday $holiday): void
    {
        $this->update([
            'holiday_from' => $holiday->getFromString(),
            'holiday_to' => $holiday->getToString(),
        ]);
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
