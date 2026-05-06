<?php

namespace App\Manager\Modules\Legal\Http\Controllers;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Modules\Legal\Readers\ProfileGetter;
use Inertia\Inertia;

class ProfileController extends AbstractController
{
    public function __construct(

    ) {}

    public function view(ProfileGetter $profileGetter)
    {
        return Inertia::render('manager/legal/settings/account/index',
            $profileGetter->get($this->getUser())
        );
    }
}
