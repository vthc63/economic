<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @return mixed
     */
    public function __invoke()
    {
        return Auth::guard('admin')->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::ADMIN)
                    : view('admin.auth.verify-email');
    }
}
