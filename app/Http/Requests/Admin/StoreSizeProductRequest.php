<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSizeProductRequest extends FormRequest
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
            'quantity' => 'required|integer|min:1',
            'product_color_id' => 'required|integer',
            'size_id' => 'required|integer',
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
            'quantity.required' => __('message.required', ['attribute' => 'Số lượng']),
            'product_color_id.required' => __('message.required', ['attribute' => 'Màu sắc']),
            'size_id.required' => __('message.required', ['attribute' => 'Kích thước']),
        ];
    }
}
