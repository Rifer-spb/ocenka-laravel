<?php

namespace App\Manager\Http\PageControllers;

use App\Core\Http\Controllers\AbstractController;
use Inertia\Inertia;
use Inertia\Response;

class IndexPageController extends AbstractController
{
    public function __invoke(): Response
    {
        return Inertia::render('manager/home');
    }
}
