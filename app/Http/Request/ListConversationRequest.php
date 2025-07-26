<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class ListConversationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => ['number'],
            'size' => ['number', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'page.number' => 'The page must be a number',
            'size.number' => 'The size must be a number',
            'size.min' => 'The size must be at least 1',
            'size.max' => 'The size must not exceed 100',
        ];
    }
}
