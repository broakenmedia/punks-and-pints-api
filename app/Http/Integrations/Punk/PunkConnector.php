<?php

namespace App\Http\Integrations\Punk;

use App\Http\Integrations\Punk\Requests\GetBeerRequest;
use App\Http\Integrations\Punk\Requests\GetBeersRequest;
use App\Http\Integrations\Punk\Requests\GetRandomBeerRequest;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\PagedPaginator;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;
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
            Limit::allow(60)->everyMinute(),
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
                return count((array) $response->json()) === 0;
            }

            protected function getPageItems(Response $response, Request $request): array
            {
                return $response->json();
            }
        };
    }

    public function getAllBeers(array $filterParams = [])
    {
        return $this->send(new GetBeersRequest($filterParams));
    }

    public function getBeer(int $beerId)
    {
        return $this->send(new GetBeerRequest($beerId));
    }

    public function getRandomBeer()
    {
        return $this->send(new GetRandomBeerRequest());
    }
}
