<?php

namespace App\Http\Controllers\Parser;

use App\Http\Controllers\Parser\BaseController;

class ParserController extends BaseController
{
    public function __invoke()
    {
        $file = file_get_contents((env('FEED_URL')));
        $data = simplexml_load_string($file, 'SimpleXMLElement', LIBXML_NOCDATA);

        $this->service->store($data);
    }
}
