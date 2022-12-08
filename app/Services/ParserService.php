<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class ParserService
{
    public function store($data)
    {
        try {
            DB::beginTransaction();

            foreach ($data->channel->item as $item)
            {
                $postData = (array)$item;

                if (isset($postData['category'])) {
                    $categories = $postData['category'];
                    unset($postData['category']);
                }

                $postData['pubDate'] = $this->createDateObject($postData['pubDate']);

                $post = Post::firstOrCreate($postData);

                if (isset($categories)) {

                    $categoryIds = $this->createCategory($categories);
                    $post->categories()->attach($categoryIds);
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500);
        }
    }


    public function update()
    {

    }

    public function delete()
    {

    }

    public function createDateObject($date)
    {
        return (new \DateTime())
            ->createFromFormat(env('FORMAT_DATE'), $date);
    }

    public function createCategory($categories)
    {
        $categoryIds = [];

        foreach ($categories as $category) {
            $category = Category::firstOrCreate(['title' => $category]);
            array_push($categoryIds, $category->id);
        }

        return $categoryIds;
    }
}
