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

    protected function unSyncCollection(string $relationName, Model $model): void
    {
        if ($this->relationLoaded($relationName)) {
            $callback = fn (Model $item) => $item->getKey() === $model->getKey();
            $this->setRelation($relationName, $this->{$relationName}->reject($callback));
        }
    }
}
