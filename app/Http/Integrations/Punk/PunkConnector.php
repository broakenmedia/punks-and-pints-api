<?php

namespace App\Http\Integrations\Punk;

use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Http\Connector;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\PagedPaginator;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\Plugins\AcceptsJson;

class PunkConnector extends Connector implements HasPagination
{
    use AcceptsJson;
    use HasRateLimits;

    public function resolveBaseUrl(): string
    {
        return 'https://api.punkapi.com/v2';
    }

    protected function resolveLimits(): array
    {
        return [
            Limit::allow(3600)->everyHour()
        ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return new MemoryStore;
    }

    public function paginate(Request $request): PagedPaginator
    {
        return new class(connector: $this, request: $request) extends PagedPaginator
        {
            protected function isLastPage(Response $response): bool
            {
                return sizeof((array) $response->json()) === 0;
            }

            protected function getPageItems(Response $response, Request $request): array
            {
                return $response->json();
            }
        };
    }
}
