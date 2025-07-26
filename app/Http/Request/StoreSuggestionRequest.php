<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuggestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topic' => [
                'required',
                'string',
                'max:1000',
                'min:3',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'topic.required' => 'The topic is required',
            'topic.string' => 'The topic must be a string',
            'topic.max' => 'The topic must not exceed 1000 characters',
            'topic.min' => 'The topic must be at least 3 characters long',
        ];
    }
}
