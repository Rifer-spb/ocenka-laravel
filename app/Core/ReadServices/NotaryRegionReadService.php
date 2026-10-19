<?php

namespace App\Core\ReadServices;

use App\Core\Entities\Notary\NotaryRegion;

class NotaryRegionReadService
{
    public function getList(): array
    {
        return NotaryRegion::orderBy('name')->get()->pluck('name', 'id')->all();
    }
}
