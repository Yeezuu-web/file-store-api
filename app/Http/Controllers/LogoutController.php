<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class LogoutController extends Controller
{
    public function __invoke()
    {
        if (EnsureFrontendRequestsAreState::formFrontend(request())) {
            Auth::guard('web')->logout();

            request()->session()->invalidate();

            request()->session()->regenerateToken();
        } else {
            // Revoke Token
        }

    }
}
