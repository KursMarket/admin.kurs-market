<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'type_id' => 'required',
            'text' => 'required',
            'url' => [
                'required',
                Rule::unique('news', 'url')->ignore($this->route('news'))
            ],
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
            'video' => 'nullable|mimes:mp4,mp3,mov,ogg,qt',
        ];
    }
}
