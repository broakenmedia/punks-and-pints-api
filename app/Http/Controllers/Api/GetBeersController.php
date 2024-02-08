<?php

namespace App\Http\Controllers\Api;

use App\Facades\PunkFacade;
use App\Http\Requests\GetBeersRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiResponse;
use Carbon\Carbon;
use OpenApi\Attributes as OA;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;

class GetBeersController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/beers",
     *     summary="Get a list of beers",
     *     tags={"Beers"},
     *
     *     @OA\Response(
     *         response="200",
     *         description="Successfully retrieved a list of beers.",
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
     *                 description="Array of beer objects.",
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
     *         response="422",
     *         description="The request failed validation.",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The ABV (Min) field must be a number. (and 1 more error)",
     *                 description="A message describing the validation error(s)."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 description="Validation errors keyed by field name.",
     *                 @OA\Property(
     *                     property="abv_gt",
     *                     type="array",
     *                     description="Validation errors for the request.",
     *
     *                     @OA\Items(
     *                         type="string",
     *                         example="The ABV (Min) field must be a number."
     *                     )
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
