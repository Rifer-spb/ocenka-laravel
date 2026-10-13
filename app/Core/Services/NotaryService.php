<?php

namespace App\Core\Services;

use App\Core\Attributes\TestClass;
use App\Core\Entities\Notary\NotaryUpdateData;
use App\Core\Finders\NotaryFinder;
use Illuminate\Support\Facades\DB;
use Tests\Integration\Core\Services\Notary\UpdateTest;

class NotaryService
{
    /**
     * @throws \Throwable
     */
    #[TestClass(UpdateTest::class)]
    public function update(int $notaryId, NotaryUpdateData $updateData): void
    {
        $notary = NotaryFinder::getById($notaryId);

        DB::transaction(function () use ($notary, $updateData) {
            $notary->edit($updateData);
            $notary->saveOrFail();
        });
    }
}
