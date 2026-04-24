<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractEntity extends Model
{
    use EloquentDocMethods;
}
