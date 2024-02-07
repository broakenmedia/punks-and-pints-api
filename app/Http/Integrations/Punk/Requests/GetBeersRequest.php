<?php

namespace App\Http\Integrations\Punk\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetBeersRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected readonly array $filterParams)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/beers';
    }

    protected function defaultQuery(): array
    {
        return $this->filterParams;
    }
}
