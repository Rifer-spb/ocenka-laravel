<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Entities\Call\Call;
use App\Core\Http\Controllers\AbstractController;
use App\Manager\ReadServices\Phys\PhysCallReadService;

class CallController extends AbstractController
{
    public function __construct(
        private PhysCallReadService $callReadService
    )
    {
    }

    public function getCall(Call $call)
    {
        $result = $this->callReadService->getCall($call);

        return [
            'call' => $result,
        ];
    }
}
