<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Saloon\Http\Response getAllBeers(array $filterParams = [])
 * @method static \Saloon\Http\Response getBeer(int $beerId)
 * @method static \Saloon\Http\Response getRandomBeer()
 *
 * @see \App\Http\Integrations\Punk\PunkConnector
 */
class PunkFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'punk_connector';
    }
}
