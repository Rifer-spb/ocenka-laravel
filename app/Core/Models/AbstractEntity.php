<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractEntity extends Model
{
    use EloquentDocMethods;
    use HasFactory;

    public static function getTableName(): string
    {
        return (new static())->getTable();
    }
}
