<?php

namespace App\Manager\ReadServices\Phys;

use App\Core\Entities\Notary\Notary;

class PhysNotaryReadService
{
    public function getNotary(Notary $notary): array
    {
        return [
            'id' => $notary->id,
            'site' => $notary->site,
            'comment' => $notary->comment,
            'useDigitalReport' => $notary->use_digital_report === null ? '' : (int)$notary->use_digital_report,
            'emails' => $notary->emails->pluck('email')->all(),
        ];
    }
}
