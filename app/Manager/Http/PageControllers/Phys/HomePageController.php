<?php

namespace App\Manager\Http\PageControllers\Phys;

use App\Core\Http\Controllers\AbstractController;
use Inertia\Inertia;
use Inertia\Response;

class HomePageController extends AbstractController
{
    public function __invoke(): Response
    {
        return Inertia::render('manager/phys/home');
    }
}
