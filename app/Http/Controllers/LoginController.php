<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class LoginController extends Controller
{
    public function __invoke()
    {
        request()->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['require']
        ]);

        if (EnsureFrontendRequestsAreStateful::formFrontend(request())) {
            $this->authenticateFrontend();
        }

        else {

        }
    }

    private function authenticateFrontend()
    {
        if (! Auth::guard('web')
            ->attempt(
                request()->only('email', 'password'),
                request()->boolean('remember')
            )
        ) {
            throw   ValidationException::withMessages([
                'email' => _('auth.failed'),
            ]);
        }
    }
}
