<?php

namespace App\Http\Controllers\Parser;

use App\Http\Controllers\Controller;
use App\Services\ParserService;


class BaseController extends Controller
{
    public $service;

    public function __construct(ParserService $service)
    {
        $this->service = $service;
    }
}
