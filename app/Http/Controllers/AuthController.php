<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('auth/signUp/signUp');
    }

    public function store(Request $request)
    {

    }
}
