<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ApiResponse implements Responsable
{
    public function __construct(
        private $data = [],
        private int $code = Response::HTTP_OK,
    ) {
    }

    public function toResponse($request)
    {
        $response = ['success' => true, 'data' => $this->data];

        return response()->json($response, $this->code);
    }
}
