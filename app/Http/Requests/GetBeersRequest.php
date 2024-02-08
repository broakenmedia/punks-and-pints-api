<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetBeersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'abv_gt' => 'numeric|gt:0',
            'abv_lt' => 'numeric|gt:0',
            'ibu_gt' => 'numeric|gt:0',
            'ibu_lt' => 'numeric|gt:0',
            'ebc_gt' => 'numeric|gt:0',
            'ebc_lt' => 'numeric|gt:0',
            'beer_name' => 'string',
            'yeast' => 'string',
            'brewed_before' => 'date_format:m-Y',
            'brewed_after' => 'date_format:m-Y',
            'hops' => 'string',
            'malt' => 'string',
            'food' => 'string',
            'page' => 'numeric',
            'per_page' => 'numeric',
        ];
    }

    public function attributes()
    {
        return [
            'abv_gt' => 'ABV (Min)',
            'abv_lt' => 'ABV (Max)',
            'ibu_gt' => 'IBU (Min)',
            'ibu_lt' => 'IBU (Max)',
            'ebc_gt' => 'EBC (Min)',
            'ebc_lt' => 'EBC (Max)',
            'beer_name' => 'Beer Name',
            'yeast' => 'Yeast Type',
            'brewed_before' => 'Brewed Before',
            'brewed_after' => 'Brewed After',
            'hops' => 'Hops Type',
            'malt' => 'Malt Type',
            'food' => 'Food Pairings',
            'page' => 'Page',
            'per_page' => 'Per Page',
        ];
    }
}
