<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required',
            'price_import' => 'required|integer',
            'price_sell' => 'required|integer',
            'brand_id' => 'required|integer',
            'category_id' => 'required|integer',
            'description' => 'required',
            'img' => 'nullable'
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
            'name.required' => __('message.required', ['attribute' => 'Tên sản phẩm']),
            'price_import.required' => __('message.required', ['attribute' => 'Giá nhập']),
            'price_sell.required' => __('message.required', ['attribute' => 'Giá bán']),
            'brand_id.required' => __('message.required', ['attribute' => 'Thương hiệu']),
            'category.required' => __('message.required', ['attribute' => 'Danh mục']),
            'description.required' => __('message.required', ['attribute' => 'Mô tả']),
        ];
    }
}
