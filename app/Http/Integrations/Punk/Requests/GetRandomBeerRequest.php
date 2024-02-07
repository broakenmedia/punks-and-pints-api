<?php

namespace App\Http\Integrations\Punk\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRandomBeerRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/beers/random';
    }
}
