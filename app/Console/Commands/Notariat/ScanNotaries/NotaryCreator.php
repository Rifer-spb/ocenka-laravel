<?php

namespace App\Console\Commands\Notariat\ScanNotaries;

use App\Core\Models\Notary\Notary;
use Illuminate\Support\Facades\DB;

class NotaryCreator
{
    /**
     * @param int $notariatId
     * @param NotaryParseResult $result
     * @return void
     * @throws \Throwable
     */
    public static function createOrUpdate(int $notariatId, NotaryParseResult $result): void
    {
        DB::transaction(function () use ($notariatId, $result) {
            $notary = Notary::findByNotaryId($notariatId);

            if (!$notary) {
                $notary = Notary::createNew(
                    $notariatId,
                    $result->region,
                    $result->name,
                    $result->address,
                    $result->phones
                );
            } else {
                $notary->region_id = $result->region->id;
                $notary->name = $result->name;
                $notary->address = $result->address;

                foreach ($result->phones as $phone) {
                    if($notary->hasPhone($phone)) {
                        continue;
                    }

                    $notary->addPhone($phone);
                }
            }

            foreach ($result->emails as $email) {
                if($notary->hasEmail($email)) {
                    continue;
                }

                $notary->addEmail($email);
            }

            $notary->is_work = !$result->isNotWork;

            if ($result->site) {
                $notary->site = $result->site;
            }

            $notary->saveOrFail();
        });
    }
}
