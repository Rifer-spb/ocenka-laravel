<?php

namespace App\Manager\Modules\Legal\Http\Controllers;

use App\Core\Http\Controllers\AbstractController;
use Inertia\Inertia;

class ProfileController extends AbstractController
{
    public function __construct(

    ) {}

    public function view()
    {
        return Inertia::render('manager/legal/settings/account/index');
    }
}
