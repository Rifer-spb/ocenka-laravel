<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Legal\LegalInviteTab;
use App\Manager\Finders\Legal\InviteFinder;

class InviteController extends AbstractController
{
    public function __construct(
        private InviteFinder $finder
    ) {}

    public function tabs()
    {
        return LegalInviteTab::all();
    }

    public function counts()
    {
        return $this->finder->getCounts($this->getUser());
    }
}
