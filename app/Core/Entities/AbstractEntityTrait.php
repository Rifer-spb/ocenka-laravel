<?php

namespace App\Core\Entities;

use Illuminate\Database\Eloquent\Model;

trait AbstractEntityTrait
{
    protected function syncCollection(string $relationName, Model $model): void
    {
        if ($this->relationLoaded($relationName)) {
            $this->{$relationName}->push($model);
        }
    }
}
