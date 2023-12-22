<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = Auth::guard('admin')->user();
        return [
            'name' => 'required|string|min:1|max:30',
            'email' => 'required|string|email|unique:users,email,' . $user->id . ',id,deleted_at,"NULL"',
            'phone_number' => 'required|min:11|max:12',
            'city' => 'required|integer',
            'district' => 'required|integer',
            'ward' => 'required|integer',
            'apartment_number' => 'required|string|min:1|max:100',
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
            'name.required' => __('message.required', ['attribute' => 'họ và tên']),
            'name.max' => __('message.max', ['attribute' => 'Họ và tên']),
            'name.min' => __('message.min', ['attribute' => 'Họ và tên']),
            'phone_number.required' => __('message.required', ['attribute' => 'số điện thoại']),
            'phone_number.min' => __('message.required', ['attribute' => 'số điện thoại']),
            'phone_number.max' => __('message.min_max_length', ['attribute' => 'số điện thoại']),
            'city.required' => __('message.required', ['attribute' => 'tỉnh, thành phố']),
            'district.required' => __('message.required', ['attribute' => 'quận, huyện']),
            'ward.required' => __('message.required', ['attribute' => 'phường, xã']),
            'apartment_number.required' => __('message.required', ['attribute' => 'số nhà']),
            'email.unique' => __('message.unique', ['attribute' => 'Email']),
            'email.email' => __('message.email'),
        ];
    }
}
