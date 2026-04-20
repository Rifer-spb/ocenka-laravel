<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DefaultController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('manager/home');
    }
}
