<?php

namespace App\Http\Controllers\Api;

use App\Facades\PunkFacade;
use App\Http\Requests\GetBeerRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiResponse;
use App\Models\Beer;
use Carbon\Carbon;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;

class GetBeerController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/beers/{beerId}",
     *     summary="Get a single beer by ID",
     *     tags={"Beers"},
     *
     *     @OA\Parameter(
     *         name="beerId",
     *         in="path",
     *         required=true,
     *         description="The ID of the beer to retrieve",
     *
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="Successfully retrieved a single beer.",
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
     *         response="422",
     *         description="The request failed validation.",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The beer id field must be a number.",
     *                 description="A message describing the validation error(s)."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 description="Validation errors keyed by field name.",
     *                 @OA\Property(
     *                     property="beerId",
     *                     type="array",
     *                     description="Validation errors for the request.",
     *
     *                     @OA\Items(
     *                         type="string",
     *                         example="The beer id field must be a number."
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
    public function __invoke(GetBeerRequest $req)
    {
        try {
            $res = PunkFacade::getBeer($req->validated('beerId'));
            if ($res->failed()) {
                return new ApiErrorResponse($res->json(), $res->status());
            }

            return new ApiResponse($res->json(), ['isSaved' => Beer::where('beer_id', $req->validated('beerId'))->first() !== null]);
        } catch (RateLimitReachedException $exception) {
            $timeRemaining = Carbon::now()->addSeconds($exception->getLimit()->getRemainingSeconds())->diffForHumans();

            return response()->rateLimitError($timeRemaining);
        }
    }
}
