<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ApiResponse implements Responsable
{
    public function __construct(
        private $data = [],
        private $extra = [],
        private int $code = Response::HTTP_OK,
    ) {
    }

    public function toResponse($request)
    {
        $response = array_merge(['success' => true, 'data' => $this->data], $this->extra);

        return response()->json($response, $this->code);
    }
}
