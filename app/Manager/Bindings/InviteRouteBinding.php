<?php

namespace App\Manager\Bindings;

use App\Core\Models\Invite\Invite;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InviteRouteBinding
{
    public function __invoke(string $value): Invite
    {
        $invite = Invite::where('id', $value)
            ->where('legal_id', auth()->id())
            ->first();

        if (! $invite) {
            throw new NotFoundHttpException();
        }

        return $invite;
    }
}
