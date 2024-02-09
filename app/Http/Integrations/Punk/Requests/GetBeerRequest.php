<?php

namespace App\Http\Integrations\Punk\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetBeerRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected readonly int $beerId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/beers/'.$this->beerId;
    }
}
