<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReviewRequest extends FormRequest
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
            'rating' => 'required|integer|in:1,2,3,4,5',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'rating.in' => 'Điểm đánh giá chỉ từ 1 - 5',
            'rating.required' => 'Điểm đánh giá không được bỏ trống',
            'content' => 'Nội dung đánh giá không được bỏ trống'
        ];
    }

}
