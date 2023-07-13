<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required',
            'prefix' => 'required',
            'school' => 'required',
            'url' => [
                'required',
                Rule::unique('courses', 'url')->ignore($this->id, 'id')
            ],
            'source_link' => 'required|url',
            'category' => 'required',
            'sub_category' => 'required',
            'show_in_rating' => 'nullable',
            'study_duration' => 'required',
            'time' => 'required',
            'selectedTags' => 'nullable',
            'price' => 'required',
            'image' => 'nullable|image'
        ];

        if ($this->has('sale') && (true === $this->sale || 'true' === $this->sale)) {
            $rules += [
                'sale_status' => 'required',
                'sale_price' => 'required|numeric'
            ];
        }

        if ($this->has('credit') && (true === $this->credit || 'true' === $this->credit)) {
            $rules += [
                'credit_month' => 'required|numeric',
                'credit_month_price' => 'required|numeric'
            ];
        }

        return $rules;
    }
}
