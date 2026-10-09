<?php

namespace App\Manager\Services\Phys;

use App\Core\Entities\Notary\Notary;
use App\Core\Entities\Notary\NotaryUpdateData;
use App\Core\Finders\NotaryFinder;
use Illuminate\Support\Facades\DB;

class PhysNotaryService
{
    /**
     * @throws \Throwable
     */
    public function update(int $notaryId, NotaryUpdateData $updateData): void
    {
        $notary = $this->getNotary($notaryId);

        if (! $updateData->hasData()) {
            throw new \DomainException('Нет полей для изменения.');
        }

        DB::transaction(function () use ($notary, $updateData) {
            $notary->removeAllEmails();

            foreach ($updateData->emails as $email) {
                $notary->addEmail($email);
            }

            $notary->setSite($updateData->site?->getValue());
            $notary->setUseDigitalReport($updateData->useDigitalReport);
            $notary->setComment($updateData->comment);

            $notary->saveOrFail();
        });
    }

    private function getNotary(int $id): Notary
    {
        return NotaryFinder::getById($id);
    }
}
