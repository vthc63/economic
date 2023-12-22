<?php

namespace App\Http\Requests\Auth;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.required' => __('validation.required', ['attribute' => 'mật khẩu']),
            'password.string' => __('validation.string', ['attribute' => 'mật khẩu']),
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();
        $email = $this->email;
        $password = $this->password;
        $user = [
            'email' => $email, 
            'password' => $password, 
            'role_id' => Role::ROLE['user'],
            'deleted_at' => null,
            'email_verified_at' => function ($query) {
                $query->where('email_verified_at', '!=', null);
            }
        ];
        
        if (! Auth::guard()->attempt($user, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        } elseif (Auth::guard()->attempt($user, $this->boolean('remember')) &&  Auth::guard()->user()->active == 0) {
            RateLimiter::hit($this->throttleKey());
            $disableReason = Auth::guard('admin')->user()->disable_reason;
            Auth::guard()->logout();
            throw ValidationException::withMessages([
                'disable_reason' => trans('auth.locked') . $disableReason,
            ]);
        }
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
