<?php

namespace App\Core\Finders;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\Notary\Notary;

class NotaryFinder
{
    public static function findByNotariatId(int $notariatId): ?Notary
    {
        return Notary::where('notariat_notary_id', $notariatId)->first();
    }

    public static function getById(int $id): Notary
    {
        $notary = Notary::find($id);

        if (! $notary) {
            throw new EntityNotFoundException("Нотариус не найден.");
        }

        return $notary;
    }
}
