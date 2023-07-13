<?php

namespace App\Http\Requests;

use App\Models\Sale;
use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type'              => 'required',
            'school_id'         => 'nullable|exists:schools,user_id',
            'course_id'         => 'nullable|exists:courses,id',
            'discount_type'     => 'required|in:' . Sale::PERCENT_DISCOUNT . ',' . Sale::FIX_DISCOUNT,
            'discount'          => 'required',
        ];
    }
}
