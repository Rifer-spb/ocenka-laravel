<?php

namespace App\Manager\Modules\Legal\Http\Controllers;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Modules\Legal\Http\Requests\Profile\UpdateCompanyRequest;
use App\Manager\Modules\Legal\Views\ProfileView;
use Inertia\Inertia;

class ProfileController extends AbstractController
{
    public function __construct(

    ) {}

    public function view(ProfileView $view)
    {
        $params = $view->get($this->getUser());

        return Inertia::render('manager/legal/settings/account/index', $params);
    }

    public function updateCompany(UpdateCompanyRequest $request)
    {

    }
}
