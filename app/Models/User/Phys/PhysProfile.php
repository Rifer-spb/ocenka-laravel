<?php

namespace App\Models\User\Phys;

use Illuminate\Database\Eloquent\Model;

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
 */
class PhysProfile extends Model
{
    protected $table = 'phys_profiles';
    protected $fillable = [
        'id',
        'first_name',
        'second_name',
        'last_name',
        'full_name',
    ];

    public function updateName(string $firstName, string $secondName, string $lastName): void
    {
        $this->update([
            'first_name' => $firstName,
            'second_name' => $secondName,
            'last_name' => $lastName,
            'full_name' => "$firstName $secondName $lastName",
        ]);
    }
}
