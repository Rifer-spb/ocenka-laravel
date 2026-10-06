<?php

namespace App\Core\Entities;

use Database\Factories\Core\Models\DirectionFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $short_name
 *
 * @method static DirectionFactory factory()
 */
class Direction extends AbstractEntity {
    public $timestamps = false;
}
