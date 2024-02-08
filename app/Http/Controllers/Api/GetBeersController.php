<?php

namespace App\Http\Controllers\Api;

use App\Facades\PunkFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetBeersRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiResponse;
use Carbon\Carbon;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;

class GetBeersController extends Controller
{
    public function __invoke(GetBeersRequest $req)
    {
        try {
            $res = PunkFacade::getAllBeers($req->validated());
            if ($res->failed()) {
                return new ApiErrorResponse($res->json(), $res->status());
            }

            return new ApiResponse($res->json());
        } catch (RateLimitReachedException $exception) {
            $timeRemaining = Carbon::now()->addSeconds($exception->getLimit()->getRemainingSeconds())->diffForHumans();

            return response()->rateLimitError($timeRemaining);
        }
    }
}
