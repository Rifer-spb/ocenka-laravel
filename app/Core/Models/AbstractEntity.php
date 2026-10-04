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

    protected function syncCollection(string $relationName, Model $model): void
    {
        if ($this->relationLoaded($relationName)) {
            $this->{$relationName}->push($model);
        }
    }
}
