<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @return mixed
     */
    public function __invoke()
    {
        $request = new Request();
        // return Auth::guard()->user()->hasVerifiedEmail()
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::ADMIN)
                    : view('admin.auth.verify-email');
    }
}
