<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return match (request()->method()) {
            'POST' => $this->createValidationRules(),
            'PUT' => $this->updateValidationRules(),
        };
    }

    private function createValidationRules(): array
    {
        return [
            //
        ];
    }

    private function updateValidationRules(): array
    {
        return [
            //
        ];
    }
}
