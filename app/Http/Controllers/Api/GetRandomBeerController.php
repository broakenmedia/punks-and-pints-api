<?php

namespace App\Http\Controllers\Api;

use App\Facades\PunkFacade;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiResponse;
use Carbon\Carbon;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;

class GetRandomBeerController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/beers/random",
     *     summary="Get a random single beer.",
     *     tags={"Beers"},
     *
     *     @OA\Response(
     *         response="200",
     *         description="Successfully retrieved a single random beer.",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true,
     *                 description="Indicates if the request was successful."
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 description="Array containing a single beer object.",
     *
     *                 @OA\Items(
     *                     type="object",
     *                     description="A beer object.",
     *                     properties={}
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response="429",
     *         description="The Punk API rate-limit has been exceeded.",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=false,
     *                 description="Indicates if the request was successful. Always false for 429 errors."
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Too many requests to Punk's API. Please try again in [DURATION].",
     *                     description="A message describing why the rate limit was exceeded."
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke()
    {
        try {
            $res = PunkFacade::getRandomBeer();
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
