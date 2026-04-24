<?php

namespace App\Manager;

use App\Core\Http\Controllers\AbstractController;
use Inertia\Inertia;
use Inertia\Response;

class DefaultController extends AbstractController
{
    public function home(): Response
    {
        return Inertia::render('manager/home');
    }
}
