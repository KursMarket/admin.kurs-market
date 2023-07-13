<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'short_title' => 'nullable|min:3|max:255',
            'name' => 'required|min:3|max:255',
            'description' => 'nullable|min:10',
            'phone' => 'required|regex:/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){9,14}(\s*)?$/',
            'email' => [
                'required',
                'regex:/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/',
                Rule::unique('users')->ignore($this->input('id'), 'id')
            ],
        ];

        if (null === $this->input('id')) {
            $rules += [
                'password' => 'required|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
            ];
        } else {
            $rules += [
                'password' => 'nullable:regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
            ];
        }

        $rules += [
            'sort_order' => 'nullable|numeric',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'url' => [
                'required',
                Rule::unique('schools')->ignore($this->input('id'), 'user_id')
            ],
            'site_link_text' => 'nullable',
            'site_link' => 'nullable',
            'meta_point' => 'nullable',
            'partner_suffix' => 'nullable',
            'partner_postfix' => 'nullable',
            'file' => 'nullable|image|mimes:jpeg,png,jpg'
        ];

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name' => 'Полное название',
            'description' => 'Описание школы',
            'file' => 'Логотип',
            'sort_order' => 'Порядковый номер в списке школ',
        ];
    }
}
