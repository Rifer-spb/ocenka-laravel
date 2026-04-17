<?php

namespace App\Http\Controllers;

use App\Actions\Auth\SignUpAction;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\SignUpRequest;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('auth/signUp/signUp');
    }

    public function store(SignUpRequest $request, SignUpAction $action)
    {
        $user = $action->signUp($request);
    }
}
