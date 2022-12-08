<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\APIService;
use App\Services\ParserService;
/**
* @OA\Tag(
*     name="Posts",
* )
*/
class BaseController extends Controller
{
    public $service;

    public function __construct(APIService $service)
    {
        $this->service = $service;
    }
}
