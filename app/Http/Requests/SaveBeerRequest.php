<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveBeerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'beer_id' => 'required|numeric',
        ];
    }
}
