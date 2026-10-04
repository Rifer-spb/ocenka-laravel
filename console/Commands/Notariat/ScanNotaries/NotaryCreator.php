<?php

namespace Console\Commands\Notariat\ScanNotaries;

use App\Core\Finder\Notary\NotaryFinder;
use App\Core\Models\Notary\NotariatId;
use App\Core\Models\Notary\Notary;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\NationalPhone;
use Illuminate\Support\Facades\DB;

class NotaryCreator
{
    /**
     * @param NotariatId $notariatId
     * @param NotaryParseResult $result
     * @return void
     * @throws \Throwable
     */
    public static function createOrUpdate(NotariatId $notariatId, NotaryParseResult $result): void
    {
        DB::transaction(function () use ($notariatId, $result) {
            $notary = NotaryFinder::findByNotariatId($notariatId->getValue());

            if (!$notary) {
                $notary = Notary::createNew(
                    $notariatId,
                    $result->region,
                    $result->name,
                    $result->address,
                    array_map(fn($p) => new NationalPhone($p), $result->phones),
                );
            } else {
                $notary->region_id = $result->region->id;
                $notary->name = $result->name;
                $notary->address = $result->address;

                foreach ($result->phones as $phone) {
                    if($notary->hasPhone($phone)) {
                        continue;
                    }

                    $notary->addPhone(new NationalPhone($phone));
                }
            }

            foreach ($result->emails as $email) {
                if($notary->hasEmail($email)) {
                    continue;
                }

                $notary->addEmail(new Email($email));
            }

            $notary->is_work = !$result->isNotWork;

            if ($result->site) {
                $notary->site = $result->site;
            }

            $notary->saveOrFail();
        });
    }
}
