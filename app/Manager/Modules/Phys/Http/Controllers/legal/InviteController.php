<?php

namespace App\Manager\Modules\Phys\Http\Controllers\legal;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Modules\Phys\Http\Requests\Legal\Invite\CreateRequest;
use App\Manager\Modules\Phys\UseCases\legal\InviteService;

class InviteController extends AbstractController
{
    public function __construct(
        private InviteService $service
    ) {}

    /**
     * @throws \Throwable
     */
    public function create(CreateRequest $request)
    {
        $this->service->create($this->getUserId(), $request);

        return redirect()->back()->with('success', 'Заявка успешно отправлена');
    }
}
