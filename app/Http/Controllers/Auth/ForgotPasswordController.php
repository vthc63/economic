<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Auth\ChangeNewPasswordRequest;
use App\Models\User;
use App\Models\UserVerify;
use App\Notifications\VerifyUserForgotPassword;
use App\Notifications\VerifyUserRegister;
use App\Repository\Eloquent\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $user = $this->userRepository->whereFirst(['email' => $request->email]);
        if (! $user) {
            throw ValidationException::withMessages([
                'email' => 'Địa chỉ email không tồn tại',
            ]);
        }
        $token = Str::random(64);
        $time = Config::get('auth.verification.expire.resend', 60);
        DB::beginTransaction();
        UserVerify::updateOrCreate(
            ['user_id' => $user->id],
            [
                'token' => $token,
                'expires_at' => Carbon::now()->addMinutes($time),
            ]
        );
        $user->notify(new VerifyUserForgotPassword($token));
        DB::commit();
        return back()->with('notify', 'Chúng tôi đã gởi liên kết xác nhận vào email của bạn vui lòng kiểm tra');
    }

    public function changePassword(Request $request)
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
                return redirect()->route('user.login');
            }

            //Rules form
            $rules = [
                'password' => [
                    'required' => true,
                    'minlength' => 8,
                    // 'maxlength' => 24,
                    'checklower' => true,
                    'checkupper' => true,
                    'checkdigit' => true,
                    'checkspecialcharacter' => true,
                ],
                'password_confirm' => [
                    'equalTo' => '#password',
                ],
            ];
    
            // Messages eror rules
            $messages = [
                'password' => [
                    'required' => __('message.required', ['attribute' => 'mật khẩu mới']),
                    'minlength' => __('message.min', ['attribute' => 'Mật khẩu mới', 'min' => 8]),
                    // 'maxlength' => __('message.max', ['attribute' => 'Mật khẩu mới', 'max' => 24]),
                    'checklower' => __('message.password.at_least_one_lowercase_letter_is_required'),
                    'checkupper' => __('message.password.at_least_one_uppercase_letter_is_required'),
                    'checkdigit' => __('message.password.at_least_one_digit_is_required'),
                    'checkspecialcharacter' => __('message.password.at_least_special_characte_is_required'),
                ],
                'password_confirm' => [
                    'equalTo' => 'Xác nhận mật khẩu không trùng khớp',
                ],
            ];
            
            return view('auth.change-password', [
                'rules' => $rules,
                'messages' => $messages,
                'token' => $request->token,
            ]);
        }
        return redirect()->route('user.login');
    }

    public function updatePassword(ChangeNewPasswordRequest $request)
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
                return redirect()->route('user.login');
            }

            $data = [
                'password' => $request->password,
                'updated_by' => $verifyUser->user->id,
            ];
            $this->userRepository->update($verifyUser->user, $data);
            $verifyUser->delete();
            return redirect()->route('user.verify.success')->with('status', 'forgot-password-success');
        }
        return redirect()->route('user.login');
    }
}
