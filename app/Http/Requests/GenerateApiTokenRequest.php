<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateApiTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token_name' => 'required|string',
        ];
    }
}
