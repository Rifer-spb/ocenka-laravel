<?php

namespace App\Core\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractEntity extends Model
{
    use HasFactory;
    use ModelHelperMethods;
    use AbstractEntityTrait;

    public $timestamps = false;

    public static function getTableName(): string
    {
        return (new static())->getTable();
    }
}
