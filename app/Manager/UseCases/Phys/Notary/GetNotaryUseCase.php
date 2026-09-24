<?php

namespace App\Manager\UseCases\Phys\Notary;

use App\Core\Models\Notary\Notary;

class GetNotaryUseCase
{
    public function execute(Notary $notary): array
    {
        return [
            'id' => $notary->id,
            'emails' => $notary->emails->pluck('email')->all(),
            'site' => $notary->site,
            'useDigitalReport' => $notary->use_digital_report === null ? '' : (int)$notary->use_digital_report,
            'comment' => $notary->comment,
        ];
    }
}
