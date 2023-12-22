<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserVerify;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        try {
            if (Auth::guard('admin')->user()->hasVerifiedEmail()) {
                return redirect()->route('admin.home');
            }
            $token = Str::random(64);
            $time = Config::get('auth.verification.expire.resend', 60);
            DB::beginTransaction();
            UserVerify::updateOrCreate(
                ['user_id' => Auth::guard('admin')->user()->id],
                [
                    'token' => $token,
                    'expires_at' => Carbon::now()->addMinutes($time),
                ]
            );
            Auth::guard('admin')->user()->resendEmailVerificationNotification($token);
            DB::commit();
            return back()->with('status', 'verification-link-sent');
        } catch (Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
}
