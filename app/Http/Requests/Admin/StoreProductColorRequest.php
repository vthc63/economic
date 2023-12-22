<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductColorRequest extends FormRequest
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
        return [
            'img' => 'required',
            'color_id' => 'required|integer',
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
            'img.required' => 'Vui lòng điền đầy đủ thông tin',
            'color_id.required' => 'Vui lòng điền đầy đủ thông tin',
            'product_id.required' => 'Vui lòng điền đầy đủ thông tin',
            'color_id.integer' => 'Màu không hợp lệ',
        ];
    }
}
