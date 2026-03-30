<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

class DefaultController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('home', [
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }
}
