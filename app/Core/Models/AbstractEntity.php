<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractEntity extends Model
{
    use HasFactory;
    use ModelHelperMethods;

    public $timestamps = false;

    public static function getTableName(): string
    {
        return (new static())->getTable();
    }
}
