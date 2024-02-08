<?php

namespace App\Http\Integrations\Punk\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class GetBeersRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function __construct(protected readonly array $filterParams = [])
    {
    }

    public function resolveEndpoint(): string
    {
        return '/beers';
    }

    protected function defaultQuery(): array
    {
        return array_merge([
            'per_page' => 25,
        ], $this->filterParams);
    }
}
