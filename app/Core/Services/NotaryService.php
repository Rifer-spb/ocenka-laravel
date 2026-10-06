<?php

namespace App\Core\Services;

use App\Core\Entities\Notary\Notary;
use App\Core\Entities\Notary\NotaryUpdateData;
use App\Core\Finders\NotaryFinder;
use Illuminate\Support\Facades\DB;

class NotaryService
{
    /**
     * @throws \Throwable
     */
    public function update(int $notaryId, NotaryUpdateData $updateData): void
    {
        $notary = $this->getNotary($notaryId);

        DB::transaction(function () use ($notary, $updateData) {
            $notary->edit($updateData);
            $notary->saveOrFail();
        });
    }

    private function getNotary(int $id): Notary
    {
        return NotaryFinder::getById($id);
    }
}
