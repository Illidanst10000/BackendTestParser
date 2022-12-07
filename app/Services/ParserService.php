<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class ParserService
{
    public function store($data)
    {

        foreach ($data->channel->item as $item) {
            $postData = (array)$item;
        }

        if (isset($postData['category'])) {
            $categories = $postData['category'];
            unset($postData['category']);
        };

        $postData['pubDate'] = $this->createDateObject($postData['pubDate']);

        // $post = Post::firstOrCreate($postData);
        dd($categories);

//        try {
//            DB::beginTransaction();
//
//
//
//
//            DB::commit();
//        }
//        catch (\Exception $exception) {
//            DB::rollBack();
//            abort(500);
//        }
    }

    public function createDateObject($date) {

        return (new \DateTime())
            ->createFromFormat('D, d M Y H:i:s O', $date);
    }
}
