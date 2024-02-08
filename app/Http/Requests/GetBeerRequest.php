<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetBeerRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge(['beerId' => $this->route('beerId')]);
    }

    public function rules(): array
    {
        return [
            'beerId' => 'numeric',
        ];
    }
}
