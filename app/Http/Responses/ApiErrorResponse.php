<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ApiErrorResponse implements Responsable
{
    public function __construct(
        private $data = [],
        private int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
    ) {
    }

    public function toResponse($request)
    {
        $response = ['success' => false, 'data' => $this->data];

        return response()->json($response, $this->code);
    }
}
