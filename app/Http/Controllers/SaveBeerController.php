<?php

namespace App\Http\Controllers;

use App\Facades\PunkFacade;
use App\Http\Requests\SaveBeerRequest;
use App\Models\Beer;
use App\Models\FoodPairing;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;
use Throwable;

class SaveBeerController extends Controller
{
    public function __invoke(SaveBeerRequest $req)
    {
        try {
            $res = PunkFacade::getBeer($req->validated('beer_id'));
            if ($res->failed()) {
                return to_route('dashboard')->withErrors($res->json());
            }

            $beerData = Arr::get($res->json(), 0);

            if ($beerData !== null) {
                try {
                    $beer = Beer::updateOrCreate(['beer_id' => $req->validated('beer_id')], $this->mapDataForInsert($beerData));
                    $beer->save();
                    $beer->foodPairings()->delete();
                    $pairings = collect(Arr::get($beerData, 'food_pairing', []))->map(function ($value) {
                        return new FoodPairing([
                            'pairing' => $value,
                        ]);
                    });
                    $beer->foodPairings()->saveMany($pairings);
                } catch (Throwable $e) {
                    dd($e);
                    Log::error($e);
                }
            }

            return to_route('dashboard');
        } catch (RateLimitReachedException $exception) {
            $timeRemaining = Carbon::now()->addSeconds($exception->getLimit()->getRemainingSeconds())->diffForHumans();

            return to_route('dashboard')->withErrors(['rate-limit' => __("Too many requests to Punks's API. Please try again in :TIME.", ['time' => $timeRemaining])]);
        }
    }

    private function mapDataForInsert(array $beerData): array
    {
        return collect($beerData)->reject(function ($value, $key) {
            return in_array($key, ['id', 'food_pairing']);
        })->map(function ($value, $key) {
            return is_array($value) ? json_encode($value) : $value;
        })->merge(['beer_id' => Arr::get($beerData, 'id')])->all();
    }
}
