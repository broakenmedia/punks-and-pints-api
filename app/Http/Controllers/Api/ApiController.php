<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(title: 'Pints & Punks API', version: '1')]
class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
