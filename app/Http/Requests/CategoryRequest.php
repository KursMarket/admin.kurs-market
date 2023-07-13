<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'sort_order' => 'nullable|numeric',
            'parent_id' => 'nullable|exists:categories,id',
            'type_id' => 'nullable|exists:catalog_types,id',
            'url' => [
                'required',
                Rule::unique('categories')->ignore($this->input('id'), 'id')
            ]
        ];
    }
}
