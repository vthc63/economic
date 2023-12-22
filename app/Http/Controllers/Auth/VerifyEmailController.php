<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class VerifyEmailController extends Controller
{
    /**
     * Show user's email address as verified.
     *
     * @return \Illuminate\View\View
     */
    public function success()
    {
        if (session('status')) {
            return view('admin.auth.verify-success');
        }

        return redirect()->route('user.login');
    }

    /**
     * Mark the authenticated user's email address as verified and remove user_verifies after verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyAccount(Request $request)
    {
        if ($request->token) {
            $token = $request->token;
            $verifyUser = UserVerify::where('token', $token)->first();
            if (empty($verifyUser) || empty($verifyUser->user)) {
                return redirect()->route('user.login')->with('error', __('message.token_is_invalid'));
            }
            $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $verifyUser->expires_at);
            $date2 = Carbon::now();
            $result = $date1->gt($date2);
            if (!$result) {
                return redirect()->route('user.verification.notice', $verifyUser->user->id);
            }
            DB::transaction(function () use ($verifyUser) {
                if ($verifyUser->email_verify) {
                    $verifyUser->user->email = $verifyUser->email_verify;
                }
                $verifyUser->user->email_verified_at = Carbon::now();
                $verifyUser->user->save();
                $verifyUser->delete();
            });
            return redirect()->route('user.verify.success')->with('status', 'verifify-success');
        }
        return redirect()->route('login');
    }
}
